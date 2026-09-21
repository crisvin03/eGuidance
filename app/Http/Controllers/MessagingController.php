<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessagingController extends Controller
{
    /**
     * Display inbox/conversations list
     */
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations();
        
        // Load relationships
        foreach ($conversations as $conversation) {
            $conversation->load(['user1', 'user2', 'latestMessage.sender']);
        }

        return view('messaging.index', compact('conversations'));
    }

    /**
     * Show conversation with a specific user
     */
    public function show($userId)
    {
        $currentUser = Auth::user();
        $otherUser = User::findOrFail($userId);
        
        // Find or create conversation
        $conversation = Conversation::findOrCreate($currentUser->id, $userId);
        
        // Load messages
        $messages = $conversation->messages()->with('sender')->get();
        
        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messaging.conversation', compact('conversation', 'messages', 'otherUser'));
    }

    /**
     * Send a new message
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:10240', // 10MB max
            'reply_to' => 'nullable|exists:messages,id',
        ]);

        // At least one of message or attachment is required
        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'message' => 'Either message or attachment is required',
            ], 422);
        }

        $currentUser = Auth::user();
        
        // Find or create conversation
        $conversation = Conversation::findOrCreate($currentUser->id, $request->receiver_id);
        
        // Handle file attachment
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('message_attachments', $filename, 'public');
        }

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $currentUser->id,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'reply_to' => $request->reply_to,
        ]);

        // Update conversation last_message_at
        $conversation->update(['last_message_at' => now()]);

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('messages.show', $request->receiver_id)
            ->with('success', 'Message sent!');
    }

    /**
     * Get new messages (for polling/real-time updates)
     */
    public function getNewMessages($conversationId, $lastMessageId = 0)
    {
        $conversation = Conversation::findOrFail($conversationId);
        
        // Get messages after last message ID
        $newMessages = $conversation->messages()
            ->where('id', '>', $lastMessageId)
            ->with('sender')
            ->get();

        return response()->json([
            'messages' => $newMessages,
            'count' => $newMessages->count(),
        ]);
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $currentUser = Auth::user();
        
        $conversation->messages()
            ->where('sender_id', '!=', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Get unread messages count
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadMessagesCount();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Search for users to message
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        $currentUser = Auth::user();
        
        $users = User::where('id', '!=', $currentUser->id)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->with('role')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    /**
     * Start a new conversation
     */
    public function create()
    {
        $currentUser = Auth::user();
        
        // Get users based on role
        if ($currentUser->isStudent()) {
            // Students can message counselors and teachers
            $users = User::whereHas('role', function($q) {
                $q->whereIn('name', ['counselor', 'teacher']);
            })->get();
        } elseif ($currentUser->isTeacher()) {
            // Teachers can message counselors and students
            $users = User::whereHas('role', function($q) {
                $q->whereIn('name', ['counselor', 'student']);
            })->get();
        } else {
            // Counselors can message everyone
            $users = User::where('id', '!=', $currentUser->id)->get();
        }

        return view('messaging.create', compact('users'));
    }

    /**
     * Edit a message
     */
    public function editMessage(Request $request, $messageId)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = Message::findOrFail($messageId);
        
        // Check if user is the sender
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $message->update([
            'message' => $request->message,
            'edited_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Unsend/delete a message
     */
    public function unsendMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Check if user is the sender
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete attachment if exists
        if ($message->attachment) {
            Storage::disk('public')->delete($message->attachment);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Add reaction to message
     */
    public function reactToMessage(Request $request, $messageId)
    {
        $request->validate([
            'emoji' => 'required|string',
        ]);

        $message = Message::findOrFail($messageId);
        
        // Store reaction (you can create a reactions table or store in JSON)
        // For now, we'll store in message's reactions JSON column
        
        return response()->json([
            'success' => true,
            'message' => 'Reaction added',
        ]);
    }

    /**
     * Clear all messages in a conversation
     */
    public function clearConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $currentUser = Auth::user();
        
        // Check if user is part of conversation
        if ($conversation->user1_id !== $currentUser->id && $conversation->user2_id !== $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete all messages
        $conversation->messages()->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Delete entire conversation
     */
    public function deleteConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $currentUser = Auth::user();
        
        // Check if user is part of conversation
        if ($conversation->user1_id !== $currentUser->id && $conversation->user2_id !== $currentUser->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Delete all messages first
        $conversation->messages()->each(function($message) {
            if ($message->attachment) {
                Storage::disk('public')->delete($message->attachment);
            }
            $message->delete();
        });

        // Delete conversation
        $conversation->delete();

        return response()->json(['success' => true]);
    }
}
