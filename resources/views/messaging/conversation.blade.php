@extends('layouts.dashboard')

@section('title', 'Chat with ' . $otherUser->name)

@section('content')
@include('student.partials.modern-styles')

<!-- Chat Header -->
<div class="modern-card mb-3" style="padding: 1rem 1.5rem; position: relative; z-index: 100;">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3 flex-grow-1">
            <div class="avatar-circle-sm">
                {{ substr($otherUser->name, 0, 1) }}
            </div>
            <div>
                <h6 class="fw-semibold mb-0" style="font-size: 1rem;">{{ $otherUser->name }}</h6>
                <small class="text-muted" style="font-size: 0.8rem;">{{ ucfirst($otherUser->role->name ?? 'User') }}</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2" style="flex-shrink: 0;">
            <!-- Search Button -->
            <button type="button" class="btn btn-light chat-action-btn" onclick="toggleSearch()">
                <i class="bi bi-search"></i>
            </button>
            
            <!-- Info Button (replaces 3-dot menu) -->
            <button type="button" class="btn btn-light chat-action-btn" onclick="toggleChatInfo()">
                <i class="bi bi-info-circle"></i>
            </button>
        </div>
    </div>
    
    <!-- Search Bar (Hidden by default) -->
    <div id="searchBar" class="mt-3" style="display: none;">
        <div class="input-group">
            <span class="input-group-text" style="border-radius: 12px 0 0 12px; border: none; background: #f3f4f6;">
                <i class="bi bi-search" style="color: #6b7280;"></i>
            </span>
            <input type="text" id="searchInput" class="form-control" placeholder="Search in conversation..." 
                   style="border: none; background: #f3f4f6; font-size: 0.9rem;"
                   onkeyup="searchMessages(this.value)">
            <button class="btn" type="button" onclick="toggleSearch()" style="border-radius: 0 12px 12px 0; border: none; background: #f3f4f6;">
                <i class="bi bi-x" style="font-size: 1.2rem; color: #6b7280;"></i>
            </button>
        </div>
        <div id="searchResults" class="mt-2" style="font-size: 0.85rem; color: #6b7280;"></div>
    </div>
</div>
<!-- Chat Messages -->
<div class="modern-card" style="padding: 0; overflow: hidden;">
    <!-- Messages Container -->
    <div id="messagesContainer" class="messages-container" style="padding: 1.5rem; background: #f0f2f5;">
        @forelse($messages as $message)
            <div class="message-wrapper mb-3 @if($message->sender_id == Auth::id()) sent @else received @endif" data-message-id="{{ $message->id }}" onmouseenter="showMessageActions({{ $message->id }})" onmouseleave="hideMessageActions({{ $message->id }})">
                <!-- Reply Label (outside bubble) -->
                <div class="reply-label" id="reply-label-{{ $message->id }}" style="display: none;">
                    <i class="bi bi-reply-fill" style="font-size: 0.7rem;"></i>
                    <span id="reply-label-text-{{ $message->id }}"></span>
                </div>
                
                <div class="message-bubble-container">
                    <!-- Message Actions (Left side for sent, Right side for received) -->
                    <div class="message-actions" id="actions-{{ $message->id }}" style="display: none;">
                        <!-- Reply Button -->
                        <button type="button" class="message-action-btn" onclick="replyToMessage({{ $message->id }}, '{{ addslashes($message->message ?? 'Attachment') }}', '{{ $message->sender_id == Auth::id() ? 'yourself' : addslashes($otherUser->name) }}')" title="Reply">
                            <i class="bi bi-reply-fill"></i>
                        </button>
                        
                        <!-- Emoji Reaction Button -->
                        <button type="button" class="message-action-btn" onclick="showEmojiPicker({{ $message->id }})" title="React">
                            <i class="bi bi-emoji-smile"></i>
                        </button>
                        
                        @if($message->sender_id == Auth::id())
                            <!-- 3-dot Menu for own messages -->
                            <div class="dropdown d-inline-block">
                                <button class="message-action-btn" type="button" id="messageMenu{{ $message->id }}" data-bs-toggle="dropdown" title="More">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end message-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="editMessage({{ $message->id }}, event)">
                                            <i class="bi bi-pencil"></i>
                                            <span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="unsendMessage({{ $message->id }}, event)">
                                            <i class="bi bi-trash"></i>
                                            <span>Unsend</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                    
                    <div class="message-bubble" data-original-text="{{ $message->message }}" data-sender-name="{{ $message->sender_id == Auth::id() ? 'You' : $otherUser->name }}">
                        <!-- Reply Indicator (inside bubble) -->
                        <div class="reply-indicator" id="reply-indicator-{{ $message->id }}" style="display: none;" onclick="scrollToMessage(this.dataset.replyToId)">
                            <div class="reply-bar"></div>
                            <div class="reply-content">
                                <div class="reply-author" id="reply-author-{{ $message->id }}"></div>
                                <div class="reply-text" id="reply-text-{{ $message->id }}"></div>
                            </div>
                        </div>
                        
                        @if($message->message)
                            <div class="message-text" id="text-{{ $message->id }}">
                                {{ $message->message }}
                            </div>
                        @endif
                        
                        @if($message->attachment)
                            @php
                                $extension = strtolower(pathinfo($message->attachment, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                            @endphp
                            
                            @if($isImage)
                                <div class="message-image-container">
                                    <a href="{{ Storage::url($message->attachment) }}" target="_blank" class="message-image-link">
                                        <img src="{{ Storage::url($message->attachment) }}" 
                                             alt="Image" 
                                             class="message-image"
                                             loading="lazy">
                                    </a>
                                </div>
                            @else
                                <div class="message-attachment">
                                    <a href="{{ Storage::url($message->attachment) }}" target="_blank" class="attachment-link">
                                        <i class="bi bi-file-earmark-text"></i>
                                        <span>{{ basename($message->attachment) }}</span>
                                    </a>
                                </div>
                            @endif
                        @endif
                        
                        <div class="message-time">
                            {{ $message->created_at->format('g:i A') }}
                            @if($message->sender_id == Auth::id())
                                <i class="bi bi-check-all ms-1 @if($message->isRead()) text-primary @endif"></i>
                            @endif
                        </div>
                        
                        <!-- Reaction Display -->
                        <div class="message-reactions" id="reactions-{{ $message->id }}" style="display: none;">
                            <!-- Reactions will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="modern-empty-state" style="padding: 3rem 2rem;">
                <div class="modern-empty-icon">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <p class="modern-empty-text">No messages yet. Start the conversation!</p>
            </div>
        @endforelse
    </div>

    <!-- Message Input -->
    <div class="message-input-container" style="padding: 1rem 1.5rem; background: white; border-top: 1px solid #e5e7eb;">
        <!-- Reply Preview -->
        <div id="replyPreview" class="reply-preview" style="display: none;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-reply-fill" style="color: var(--green);"></i>
                    <div>
                        <div class="reply-preview-label" style="font-size: 0.75rem; color: #6b7280;">Replying to <span id="replyToName"></span></div>
                        <div class="reply-preview-text" id="replyPreviewText" style="font-size: 0.85rem; color: #374151;"></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm" onclick="cancelReply()" style="border: none; background: transparent; color: #6b7280;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
        
        <form id="messageForm" action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
            <input type="hidden" id="replyToMessageId" name="reply_to" value="">
            
            <div class="input-group" style="gap: 0.5rem;">
                <button type="button" class="btn btn-light" onclick="document.getElementById('attachmentInput').click()" style="border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; border: none; background: #f3f4f6;">
                    <i class="bi bi-paperclip" style="font-size: 1.1rem; color: #6b7280;"></i>
                </button>
                <input type="file" id="attachmentInput" name="attachment" class="d-none" accept="image/*,application/pdf,.doc,.docx" onchange="handleFileSelect(this)">
                
                <div style="flex: 1; position: relative;">
                    <textarea 
                        name="message" 
                        id="messageInput" 
                        class="form-control message-input" 
                        placeholder="Type a message..." 
                        rows="1"
                        style="resize: none; border-radius: 24px; border: none; background: #f3f4f6; padding: 0.75rem 1.25rem; font-size: 0.95rem; min-height: 42px; max-height: 120px;"
                        required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary send-button" id="sendButton" style="border-radius: 50%; width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--green), var(--green-dark)); border: none;">
                    <i class="bi bi-send-fill" style="font-size: 1rem;"></i>
                </button>
            </div>
            
            <div id="attachmentPreview" class="mt-2" style="display:none;">
                <!-- Image Preview -->
                <div id="imagePreview" style="display:none; position:relative; display: inline-block;">
                    <img id="previewImage" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 12px; object-fit: cover; border: 2px solid #e5e7eb;">
                    <button type="button" class="btn btn-sm btn-danger" onclick="clearAttachment()" style="position:absolute; top: -8px; right: -8px; padding: 0.25rem 0.5rem; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">
                        <i class="bi bi-x" style="font-size: 1rem;"></i>
                    </button>
                </div>
                
                <!-- File Preview -->
                <div id="filePreview" style="display:none; padding: 0.75rem 1rem; background: #f3f4f6; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-file-earmark-text" style="font-size: 1.25rem; color: var(--green);"></i>
                    <span id="attachmentName" style="font-size: 0.9rem; color: #374151;"></span>
                    <button type="button" class="btn btn-sm" onclick="clearAttachment()" style="padding: 0; background: transparent; border: none; color: #ef4444; margin-left: 0.5rem;">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.avatar-circle-sm {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #1e7a4a, #145e38);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.messages-container {
    height: 550px;
    overflow-y: auto;
    background: #f0f2f5;
    background-image: 
        linear-gradient(45deg, rgba(30, 122, 74, 0.02) 25%, transparent 25%),
        linear-gradient(-45deg, rgba(30, 122, 74, 0.02) 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, rgba(30, 122, 74, 0.02) 75%),
        linear-gradient(-45deg, transparent 75%, rgba(30, 122, 74, 0.02) 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
}

.message-wrapper {
    display: flex;
    margin-bottom: 0.5rem;
    clear: both;
    position: relative;
}

.message-wrapper.sent {
    justify-content: flex-end;
}

.message-wrapper.received {
    justify-content: flex-start;
}

.message-bubble-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    max-width: 65%;
}

.message-wrapper.sent .message-bubble-container {
    flex-direction: row; /* Actions on left, bubble on right */
}

.message-wrapper.received .message-bubble-container {
    flex-direction: row; /* Bubble on left, actions on right */
}

.message-bubble {
    position: relative;
    animation: messageSlideIn 0.2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    flex-shrink: 1;
}

.message-wrapper.sent .message-bubble {
    background: linear-gradient(135deg, #1e7a4a, #16a34a);
    border-radius: 12px 12px 2px 12px;
    padding: 8px 12px;
}

.message-wrapper.received .message-bubble {
    background: white;
    border-radius: 12px 12px 12px 2px;
    padding: 8px 12px;
}

.message-text {
    word-wrap: break-word;
    line-height: 1.4;
    font-size: 0.95rem;
    margin-bottom: 4px;
}

.message-wrapper.sent .message-text {
    color: white;
}

.message-wrapper.received .message-text {
    color: #111827;
}

.message-time {
    font-size: 0.7rem;
    margin-top: 4px;
    text-align: right;
    opacity: 0.8;
}

.message-wrapper.sent .message-time {
    color: rgba(255, 255, 255, 0.9);
}

.message-wrapper.received .message-time {
    color: #6b7280;
}

/* Message Image Styles */
.message-image-container {
    margin-top: 4px;
    margin-bottom: 4px;
}

.message-image {
    max-width: 280px;
    width: 100%;
    height: auto;
    max-height: 350px;
    border-radius: 8px;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.15s ease;
    display: block;
}

.message-image:hover {
    transform: scale(1.02);
}

.message-image-link {
    display: inline-block;
    text-decoration: none;
}

.message-wrapper.sent .message-image {
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.message-wrapper.received .message-image {
    border: 2px solid rgba(229, 231, 235, 0.5);
}

/* Message Attachment Styles */
.message-attachment {
    margin-top: 4px;
    padding: 8px 12px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 8px;
}

.message-wrapper.sent .message-attachment {
    background: rgba(255, 255, 255, 0.15);
}

.attachment-link {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.message-wrapper.sent .attachment-link {
    color: white;
}

.message-wrapper.received .attachment-link {
    color: var(--green);
}

.attachment-link:hover {
    text-decoration: underline;
}

/* Input Styles */
.message-input:focus {
    box-shadow: none !important;
    outline: none !important;
}

.send-button:hover {
    opacity: 0.9;
    transform: scale(1.05);
}

.send-button:active {
    transform: scale(0.95);
}

@keyframes messageSlideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes messageSlideOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(50px);
    }
}

/* Scrollbar styling */
.messages-container::-webkit-scrollbar {
    width: 6px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

.messages-container::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

/* Message Actions */
.message-actions {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    opacity: 0;
    transition: opacity 0.2s ease;
    flex-shrink: 0;
}

.message-wrapper:hover .message-actions {
    opacity: 1;
}

.message-wrapper.sent .message-actions {
    order: -1; /* Show on left for sent messages */
}

.message-wrapper.received .message-actions {
    order: 1; /* Show on right for received messages */
}

.message-action-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: white;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    font-size: 0.9rem;
}

.message-action-btn:hover {
    background: #f3f4f6;
    transform: scale(1.1);
}

.message-action-btn:active {
    transform: scale(0.95);
}

/* Message Dropdown Menu */
.message-dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 150px;
    border: none;
}

.message-dropdown-menu .dropdown-item {
    padding: 0.5rem 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.message-dropdown-menu .dropdown-item i {
    font-size: 1rem;
    color: var(--green);
}

.message-dropdown-menu .dropdown-item.text-danger i {
    color: #ef4444;
}

/* Emoji Picker Popup */
.emoji-picker-popup {
    position: absolute;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    padding: 0.75rem;
    display: none;
    z-index: 1000;
    animation: popIn 0.2s ease;
}

.emoji-picker-popup.show {
    display: block;
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 0.25rem;
}

.emoji-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    font-size: 1.5rem;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.emoji-btn:hover {
    background: #f3f4f6;
    transform: scale(1.2);
}

/* Reply Indicator */
.reply-indicator {
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 8px;
    background: rgba(0, 0, 0, 0.05);
    display: flex;
    gap: 0.5rem;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.15s ease;
}

.reply-indicator:hover {
    background: rgba(0, 0, 0, 0.08);
}

.message-wrapper.sent .reply-indicator {
    background: rgba(255, 255, 255, 0.2);
}

.message-wrapper.sent .reply-indicator:hover {
    background: rgba(255, 255, 255, 0.3);
}

.reply-bar {
    width: 3px;
    background: var(--green);
    border-radius: 2px;
    flex-shrink: 0;
}

.reply-content {
    flex: 1;
    min-width: 0;
}

.reply-author {
    font-weight: 600;
    font-size: 0.75rem;
    margin-bottom: 0.125rem;
    color: var(--green);
}

.message-wrapper.sent .reply-author {
    color: rgba(255, 255, 255, 0.95);
}

.reply-text {
    color: inherit;
    opacity: 0.75;
    font-size: 0.8rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

/* Reply Label (above message bubble) */
.reply-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding-left: 0.5rem;
}

.message-wrapper.sent .reply-label {
    justify-content: flex-end;
    padding-right: 0.5rem;
    padding-left: 0;
}

/* Reply Preview in Input */
.reply-preview {
    background: #f9fafb;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    border-left: 3px solid var(--green);
}

/* Message Reactions */
.message-reactions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
    margin-top: 0.25rem;
}

.reaction-badge {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 0.125rem 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.15s ease;
}

.reaction-badge:hover {
    background: #f3f4f6;
    transform: scale(1.05);
}

.reaction-badge.user-reacted {
    background: #dcfce7;
    border-color: var(--green);
}

.reaction-emoji {
    font-size: 1rem;
}

.reaction-count {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 500;
}

/* Edit Mode */
.message-editing {
    border: 2px solid var(--green);
    background: rgba(30, 122, 74, 0.05) !important;
}

.edit-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.edit-actions button {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    border: none;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-save-edit {
    background: var(--green);
    color: white;
}

.btn-save-edit:hover {
    background: var(--green-dark);
}

.btn-cancel-edit {
    background: #e5e7eb;
    color: #374151;
}

.btn-cancel-edit:hover {
    background: #d1d5db;
}

@keyframes popIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Custom Confirmation Modal */
.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.custom-modal {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-modal-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
}

.custom-modal-icon.warning {
    background: #fef3c7;
    color: #f59e0b;
}

.custom-modal-icon.danger {
    background: #fee2e2;
    color: #ef4444;
}

.custom-modal-icon.success {
    background: #dcfce7;
    color: var(--green);
}

.custom-modal-icon.info {
    background: #dbeafe;
    color: #3b82f6;
}

.custom-modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    margin-bottom: 0.5rem;
    text-align: center;
}

.custom-modal-message {
    color: #6b7280;
    font-size: 0.95rem;
    text-align: center;
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

.custom-modal-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}

.custom-modal-btn {
    padding: 0.625rem 1.5rem;
    border-radius: 8px;
    border: none;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.15s ease;
    min-width: 100px;
}

.custom-modal-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.custom-modal-btn:active {
    transform: translateY(0);
}

.custom-modal-btn-primary {
    background: var(--green);
    color: white;
}

.custom-modal-btn-primary:hover {
    background: var(--green-dark);
}

.custom-modal-btn-danger {
    background: #ef4444;
    color: white;
}

.custom-modal-btn-danger:hover {
    background: #dc2626;
}

.custom-modal-btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.custom-modal-btn-secondary:hover {
    background: #e5e7eb;
}

/* Responsive */
@media (max-width: 768px) {
    .message-bubble {
        max-width: 85%;
    }
    
    .message-image {
        max-width: 240px;
        max-height: 300px;
    }
}

/* Dropdown Menu Styling */
.dropdown-menu {
    border: none;
}

.dropdown-item {
    transition: background-color 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f3f4f6;
}

.dropdown-item:active {
    background-color: #e5e7eb;
}

/* Chat Action Buttons */
.chat-action-btn {
    border-radius: 50%;
    width: 38px;
    height: 38px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: #f3f4f6;
    transition: all 0.2s ease;
}

.chat-action-btn i {
    font-size: 1rem;
    color: #6b7280;
}

.chat-action-btn:hover {
    background: #e5e7eb;
}

/* Chat Info Sidebar */
.chat-info-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 360px;
    height: 100vh;
    background: white;
    box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
    transition: right 0.3s ease;
    z-index: 1050;
    overflow-y: auto;
}

.chat-info-sidebar.active {
    right: 0;
}

.chat-info-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1049;
}

.chat-info-overlay.active {
    opacity: 1;
    visibility: visible;
}

.chat-info-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f9fafb;
}

.chat-info-header h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #111827;
}

.btn-close-sidebar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: #e5e7eb;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
}

.btn-close-sidebar:hover {
    background: #d1d5db;
    color: #374151;
}

.chat-info-body {
    padding: 0;
}

.chat-info-section {
    border-bottom: 1px solid #e5e7eb;
    padding: 0.75rem 0;
}

.chat-info-section-header {
    padding: 0.75rem 1.5rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.chat-info-item {
    padding: 0.875rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
    transition: background 0.15s ease;
}

.chat-info-item:hover {
    background: #f9fafb;
}

.chat-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--green);
    font-size: 1.1rem;
}

.chat-info-icon.danger {
    background: #fee2e2;
    color: #ef4444;
}

.chat-info-text {
    flex: 1;
    min-width: 0;
}

.chat-info-title {
    font-size: 0.95rem;
    font-weight: 500;
    color: #111827;
    margin-bottom: 0.125rem;
}

.chat-info-subtitle {
    font-size: 0.8rem;
    color: #6b7280;
}

.avatar-circle-lg {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1e7a4a, #145e38);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 2rem;
}

/* Responsive - sidebar full width on mobile */
@media (max-width: 768px) {
    .chat-info-sidebar {
        width: 100%;
        right: -100%;
    }
}

/* Chat Dropdown Menu */
.chat-dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 200px;
    margin-top: 0.5rem;
}

.chat-dropdown-menu .dropdown-item {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chat-dropdown-menu .dropdown-item i {
    font-size: 1.1rem;
    color: var(--green);
}

.chat-dropdown-menu .dropdown-item.text-danger i {
    color: #ef4444;
}

/* Search highlight */
mark {
    animation: highlightFade 0.3s ease;
}

@keyframes highlightFade {
    from {
        background-color: #fef08a;
    }
    to {
        background-color: #fef08a;
    }
}
</style>

<script>
let lastMessageId = {{ $messages->last()->id ?? 0 }};
const conversationId = {{ $conversation->id }};
const currentUserId = {{ Auth::id() }};
const otherUserId = {{ $otherUser->id }};

// Scroll to bottom on load
document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
    
    // Auto-resize textarea
    const textarea = document.getElementById('messageInput');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Submit on Enter (Shift+Enter for new line)
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('messageForm').dispatchEvent(new Event('submit'));
        }
    });
});

function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    container.scrollTop = container.scrollHeight;
}

// Handle file selection
function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        const fileType = file.type;
        
        // Show preview container
        document.getElementById('attachmentPreview').style.display = 'block';
        
        // Check if it's an image
        if (fileType.startsWith('image/')) {
            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('filePreview').style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            // Show file name for non-images
            document.getElementById('attachmentName').textContent = fileName;
            document.getElementById('filePreview').style.display = 'block';
            document.getElementById('imagePreview').style.display = 'none';
        }
    }
}

function clearAttachment() {
    document.getElementById('attachmentInput').value = '';
    document.getElementById('attachmentPreview').style.display = 'none';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('filePreview').style.display = 'none';
    document.getElementById('previewImage').src = '';
}

// Handle form submission
document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sendButton = document.getElementById('sendButton');
    const messageInput = document.getElementById('messageInput');
    
    // Disable send button
    sendButton.disabled = true;
    sendButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    
    fetch('{{ route('messages.store') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add message to UI
            addMessageToUI(data.message);
            
            // Clear form
            messageInput.value = '';
            messageInput.style.height = 'auto';
            clearAttachment();
            
            // Update last message ID
            lastMessageId = data.message.id;
            
            // Scroll to bottom
            scrollToBottom();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to send message. Please try again.');
    })
    .finally(() => {
        // Re-enable send button
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send-fill"></i>';
    });
});

function addMessageToUI(message) {
    const container = document.getElementById('messagesContainer');
    const isSent = message.sender_id === currentUserId;
    
    // Check if attachment is an image
    let attachmentHtml = '';
    if (message.attachment) {
        const extension = message.attachment.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'].includes(extension);
        
        if (isImage) {
            attachmentHtml = `
                <div class="message-image-container">
                    <a href="/storage/${message.attachment}" target="_blank" class="message-image-link">
                        <img src="/storage/${message.attachment}" 
                             alt="Image" 
                             class="message-image"
                             loading="lazy">
                    </a>
                </div>
            `;
        } else {
            attachmentHtml = `
                <div class="message-attachment">
                    <a href="/storage/${message.attachment}" target="_blank" class="attachment-link">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>${message.attachment.split('/').pop()}</span>
                    </a>
                </div>
            `;
        }
    }
    
    const messageText = message.message ? `<div class="message-text">${escapeHtml(message.message)}</div>` : '';
    
    // Reply indicator HTML
    let replyHtml = '';
    let replyLabelHtml = '';
    if (replyingToMessageId) {
        replyHtml = `
            <div class="reply-indicator" onclick="scrollToMessage(${replyingToMessageId})" data-reply-to-id="${replyingToMessageId}">
                <div class="reply-bar"></div>
                <div class="reply-content">
                    <div class="reply-author">${escapeHtml(replyingToName)}</div>
                    <div class="reply-text">${escapeHtml(replyingToText.length > 40 ? replyingToText.substring(0, 40) + '...' : replyingToText)}</div>
                </div>
            </div>
        `;
        replyLabelHtml = `
            <div class="reply-label">
                <i class="bi bi-reply-fill" style="font-size: 0.7rem;"></i>
                <span>You replied to ${escapeHtml(replyingToName)}</span>
            </div>
        `;
    }
    
    const messageHtml = `
        <div class="message-wrapper mb-3 ${isSent ? 'sent' : 'received'}" data-message-id="${message.id}">
            ${replyLabelHtml}
            <div class="message-bubble-container">
                <div class="message-actions" style="display: none;">
                    <button type="button" class="message-action-btn" onclick="replyToMessage(${message.id}, '${escapeHtml(message.message || 'Attachment')}', '${isSent ? 'yourself' : escapeHtml('{{ $otherUser->name }}')}')">
                        <i class="bi bi-reply-fill"></i>
                    </button>
                    <button type="button" class="message-action-btn" onclick="showEmojiPicker(${message.id})">
                        <i class="bi bi-emoji-smile"></i>
                    </button>
                    ${isSent ? `
                        <div class="dropdown d-inline-block">
                            <button class="message-action-btn" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end message-dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editMessage(${message.id}, event)">
                                    <i class="bi bi-pencil"></i><span>Edit</span>
                                </a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="unsendMessage(${message.id}, event)">
                                    <i class="bi bi-trash"></i><span>Unsend</span>
                                </a></li>
                            </ul>
                        </div>
                    ` : ''}
                </div>
                <div class="message-bubble" data-original-text="${escapeHtml(message.message || '')}" data-sender-name="${isSent ? 'You' : escapeHtml('{{ $otherUser->name }}')}">
                    ${replyHtml}
                    ${messageText}
                    ${attachmentHtml}
                    <div class="message-time">
                        ${formatTime(new Date())}
                        ${isSent ? '<i class="bi bi-check-all ms-1"></i>' : ''}
                    </div>
                    <div class="message-reactions" id="reactions-${message.id}" style="display: none;"></div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', messageHtml);
    
    // Clear reply state after sending
    if (replyingToMessageId) {
        cancelReply();
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatTime(date) {
    return date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
}

// Poll for new messages every 3 seconds
setInterval(function() {
    fetch(`/messages/new/${conversationId}/${lastMessageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.count > 0) {
                data.messages.forEach(message => {
                    addMessageToUI(message);
                    lastMessageId = message.id;
                });
                scrollToBottom();
                
                // Mark as read
                fetch(`/messages/read/${conversationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                });
            }
        })
        .catch(error => console.error('Polling error:', error));
}, 3000); // Poll every 3 seconds for real-time feel

// Custom Confirmation Dialog
function showConfirmDialog(title, message, type = 'warning') {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        overlay.className = 'custom-modal-overlay';
        
        const iconClass = type === 'danger' ? 'bi-exclamation-triangle-fill' : 
                         type === 'warning' ? 'bi-question-circle-fill' :
                         type === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill';
        
        overlay.innerHTML = `
            <div class="custom-modal">
                <div class="custom-modal-icon ${type}">
                    <i class="bi ${iconClass}"></i>
                </div>
                <h3 class="custom-modal-title">${title}</h3>
                <p class="custom-modal-message">${message}</p>
                <div class="custom-modal-actions">
                    <button class="custom-modal-btn custom-modal-btn-secondary" onclick="closeConfirmDialog(false)">
                        Cancel
                    </button>
                    <button class="custom-modal-btn custom-modal-btn-${type === 'danger' ? 'danger' : 'primary'}" onclick="closeConfirmDialog(true)">
                        ${type === 'danger' ? 'Delete' : 'Confirm'}
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        window.closeConfirmDialog = (result) => {
            overlay.remove();
            delete window.closeConfirmDialog;
            resolve(result);
        };
        
        // Close on overlay click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                window.closeConfirmDialog(false);
            }
        });
    });
}

// Custom Alert Dialog
function showAlertDialog(title, message, type = 'info') {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        overlay.className = 'custom-modal-overlay';
        
        const iconClass = type === 'danger' ? 'bi-x-circle-fill' : 
                         type === 'warning' ? 'bi-exclamation-triangle-fill' :
                         type === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill';
        
        overlay.innerHTML = `
            <div class="custom-modal">
                <div class="custom-modal-icon ${type}">
                    <i class="bi ${iconClass}"></i>
                </div>
                <h3 class="custom-modal-title">${title}</h3>
                <p class="custom-modal-message">${message}</p>
                <div class="custom-modal-actions">
                    <button class="custom-modal-btn custom-modal-btn-primary" onclick="closeAlertDialog()">
                        OK
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        window.closeAlertDialog = () => {
            overlay.remove();
            delete window.closeAlertDialog;
            resolve();
        };
        
        // Close on overlay click
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                window.closeAlertDialog();
            }
        });
    });
}

// Show/hide message actions on hover
function showMessageActions(messageId) {
    const actions = document.getElementById(`actions-${messageId}`);
    if (actions) {
        actions.style.display = 'flex';
        actions.style.opacity = '1';
    }
}

function hideMessageActions(messageId) {
    const actions = document.getElementById(`actions-${messageId}`);
    if (actions) {
        // Don't hide if dropdown is open
        const dropdown = actions.querySelector('.dropdown-menu.show');
        if (!dropdown) {
            actions.style.display = 'none';
            actions.style.opacity = '0';
        }
    }
}

// Emoji Picker
const emojis = ['❤️', '😂', '😮', '😢', '😡', '👍', '👎', '🎉', '🔥', '💯', '✨', '🙏'];
let currentEmojiPickerMessageId = null;
let userReactions = {}; // Track user's reactions per message

function showEmojiPicker(messageId) {
    // Remove existing emoji picker
    const existingPicker = document.querySelector('.emoji-picker-popup');
    if (existingPicker) {
        existingPicker.remove();
    }
    
    currentEmojiPickerMessageId = messageId;
    
    // Create emoji picker
    const picker = document.createElement('div');
    picker.className = 'emoji-picker-popup show';
    picker.innerHTML = `
        <div class="emoji-grid">
            ${emojis.map(emoji => `
                <button class="emoji-btn" onclick="addReaction(${messageId}, '${emoji}')">${emoji}</button>
            `).join('')}
        </div>
    `;
    
    // Position near the message
    const messageWrapper = document.querySelector(`[data-message-id="${messageId}"]`);
    const rect = messageWrapper.getBoundingClientRect();
    const container = document.getElementById('messagesContainer');
    const containerRect = container.getBoundingClientRect();
    
    picker.style.position = 'absolute';
    picker.style.top = (rect.top - containerRect.top - 60) + 'px';
    picker.style.left = (rect.left - containerRect.left + 50) + 'px';
    
    container.appendChild(picker);
    
    // Close picker when clicking outside
    setTimeout(() => {
        document.addEventListener('click', function closeEmojiPicker(e) {
            if (!e.target.closest('.emoji-picker-popup') && !e.target.closest('.message-action-btn')) {
                picker.remove();
                document.removeEventListener('click', closeEmojiPicker);
            }
        });
    }, 100);
}

function addReaction(messageId, emoji) {
    // Remove emoji picker
    const picker = document.querySelector('.emoji-picker-popup');
    if (picker) picker.remove();
    
    const reactionsDiv = document.getElementById(`reactions-${messageId}`);
    
    // Check if user already reacted to this message
    const previousReaction = userReactions[messageId];
    
    if (previousReaction === emoji) {
        // Same emoji - remove it (unlike)
        removeReaction(messageId, emoji);
        delete userReactions[messageId];
        return;
    }
    
    if (previousReaction) {
        // Different emoji - remove old one first
        removeReaction(messageId, previousReaction);
    }
    
    // Add new reaction
    userReactions[messageId] = emoji;
    
    // Check if reaction badge already exists
    const existingBadge = Array.from(reactionsDiv.children).find(
        child => child.dataset.emoji === emoji
    );
    
    if (existingBadge) {
        // Increment count and mark as user-reacted
        const countSpan = existingBadge.querySelector('.reaction-count');
        const currentCount = parseInt(countSpan.textContent) || 1;
        countSpan.textContent = currentCount + 1;
        existingBadge.classList.add('user-reacted');
    } else {
        // Add new reaction badge
        const reactionBadge = document.createElement('span');
        reactionBadge.className = 'reaction-badge user-reacted';
        reactionBadge.dataset.emoji = emoji;
        reactionBadge.innerHTML = `
            <span class="reaction-emoji">${emoji}</span>
            <span class="reaction-count">1</span>
        `;
        reactionsDiv.appendChild(reactionBadge);
        reactionsDiv.style.display = 'flex';
    }
    
    // Send to server
    fetch(`/messages/${messageId}/react`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ emoji: emoji })
    }).catch(error => console.error('Error adding reaction:', error));
}

function removeReaction(messageId, emoji) {
    const reactionsDiv = document.getElementById(`reactions-${messageId}`);
    const badge = Array.from(reactionsDiv.children).find(
        child => child.dataset.emoji === emoji
    );
    
    if (!badge) return;
    
    const countSpan = badge.querySelector('.reaction-count');
    const currentCount = parseInt(countSpan.textContent) || 1;
    
    if (currentCount <= 1) {
        // Remove badge completely
        badge.remove();
        // Hide reactions div if empty
        if (reactionsDiv.children.length === 0) {
            reactionsDiv.style.display = 'none';
        }
    } else {
        // Decrement count and remove user-reacted class
        countSpan.textContent = currentCount - 1;
        badge.classList.remove('user-reacted');
    }
}

// Reply to Message
let replyingToMessageId = null;
let replyingToText = '';
let replyingToName = '';

function replyToMessage(messageId, messageText, senderName) {
    replyingToMessageId = messageId;
    replyingToText = messageText;
    replyingToName = senderName;
    
    // Show reply preview
    document.getElementById('replyPreview').style.display = 'block';
    document.getElementById('replyToName').textContent = senderName;
    document.getElementById('replyPreviewText').textContent = messageText.length > 50 
        ? messageText.substring(0, 50) + '...' 
        : messageText;
    document.getElementById('replyToMessageId').value = messageId;
    
    // Focus on message input
    document.getElementById('messageInput').focus();
}

function cancelReply() {
    replyingToMessageId = null;
    replyingToText = '';
    replyingToName = '';
    document.getElementById('replyPreview').style.display = 'none';
    document.getElementById('replyToMessageId').value = '';
}

function scrollToMessage(messageId) {
    if (!messageId) return;
    
    const messageWrapper = document.querySelector(`[data-message-id="${messageId}"]`);
    if (messageWrapper) {
        messageWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Highlight briefly
        const bubble = messageWrapper.querySelector('.message-bubble');
        bubble.style.boxShadow = '0 0 0 3px rgba(30, 122, 74, 0.3)';
        setTimeout(() => {
            bubble.style.boxShadow = '0 1px 2px rgba(0,0,0,0.1)';
        }, 1500);
    }
}

// Edit Message
let editingMessageId = null;

function editMessage(messageId, event) {
    event.preventDefault();
    
    if (editingMessageId) {
        cancelEdit();
    }
    
    editingMessageId = messageId;
    
    const messageBubble = document.querySelector(`[data-message-id="${messageId}"] .message-bubble`);
    const messageText = document.getElementById(`text-${messageId}`);
    const originalText = messageBubble.dataset.originalText;
    
    // Add editing class
    messageBubble.classList.add('message-editing');
    
    // Replace text with input
    messageText.innerHTML = `
        <textarea 
            id="edit-input-${messageId}" 
            class="form-control" 
            style="border: none; background: transparent; resize: none; font-size: 0.95rem; padding: 0; color: inherit;"
            rows="2"
        >${originalText}</textarea>
        <div class="edit-actions">
            <button class="btn-save-edit" onclick="saveEdit(${messageId})">
                <i class="bi bi-check-lg"></i> Save
            </button>
            <button class="btn-cancel-edit" onclick="cancelEdit()">
                <i class="bi bi-x-lg"></i> Cancel
            </button>
        </div>
    `;
    
    // Focus on input
    const input = document.getElementById(`edit-input-${messageId}`);
    input.focus();
    input.setSelectionRange(input.value.length, input.value.length);
    
    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
}

async function saveEdit(messageId) {
    const input = document.getElementById(`edit-input-${messageId}`);
    const newText = input.value.trim();
    
    if (!newText) {
        await showAlertDialog('Empty Message', 'Message cannot be empty.', 'warning');
        return;
    }
    
    // Send to server
    fetch(`/messages/${messageId}/edit`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ message: newText })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const messageText = document.getElementById(`text-${messageId}`);
            const messageBubble = document.querySelector(`[data-message-id="${messageId}"] .message-bubble`);
            
            messageText.textContent = newText;
            messageBubble.dataset.originalText = newText;
            messageBubble.classList.remove('message-editing');
            
            editingMessageId = null;
        } else {
            showAlertDialog('Error', 'Failed to edit message. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlertDialog('Error', 'Failed to edit message. Please try again.', 'danger');
    });
}

function cancelEdit() {
    if (!editingMessageId) return;
    
    const messageText = document.getElementById(`text-${editingMessageId}`);
    const messageBubble = document.querySelector(`[data-message-id="${editingMessageId}"] .message-bubble`);
    const originalText = messageBubble.dataset.originalText;
    
    messageText.textContent = originalText;
    messageBubble.classList.remove('message-editing');
    
    editingMessageId = null;
}

// Unsend Message
async function unsendMessage(messageId, event) {
    event.preventDefault();
    
    const confirmed = await showConfirmDialog(
        'Unsend Message',
        'Are you sure you want to unsend this message? This action cannot be undone.',
        'danger'
    );
    
    if (!confirmed) return;
    
    fetch(`/messages/${messageId}/unsend`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove message from UI
            const messageWrapper = document.querySelector(`[data-message-id="${messageId}"]`);
            messageWrapper.style.animation = 'messageSlideOut 0.2s ease';
            setTimeout(() => {
                messageWrapper.remove();
            }, 200);
        } else {
            showAlertDialog('Error', 'Failed to unsend message. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlertDialog('Error', 'Failed to unsend message. Please try again.', 'danger');
    });
}

// Toggle Chat Info Sidebar
function toggleChatInfo() {
    const sidebar = document.getElementById('chatInfoSidebar');
    const overlay = document.getElementById('chatInfoOverlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Prevent body scroll when sidebar is open
    if (sidebar.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Focus on search from sidebar
function focusSearch() {
    toggleChatInfo();
    toggleSearch();
}

// Toggle search bar
function toggleSearch() {
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    
    if (searchBar.style.display === 'none') {
        searchBar.style.display = 'block';
        searchInput.focus();
    } else {
        searchBar.style.display = 'none';
        searchInput.value = '';
        document.getElementById('searchResults').innerHTML = '';
        // Remove highlights
        document.querySelectorAll('.message-text').forEach(el => {
            el.innerHTML = el.textContent;
        });
    }
}

// Search messages
function searchMessages(query) {
    const resultsDiv = document.getElementById('searchResults');
    
    if (!query.trim()) {
        resultsDiv.innerHTML = '';
        document.querySelectorAll('.message-text').forEach(el => {
            el.innerHTML = el.textContent;
        });
        return;
    }
    
    const messages = document.querySelectorAll('.message-wrapper');
    let foundCount = 0;
    
    messages.forEach(msg => {
        const textEl = msg.querySelector('.message-text');
        if (!textEl) return;
        
        const text = textEl.textContent;
        const regex = new RegExp(`(${query})`, 'gi');
        
        if (text.match(regex)) {
            foundCount++;
            textEl.innerHTML = text.replace(regex, '<mark style="background: #fef08a; padding: 2px 4px; border-radius: 3px;">$1</mark>');
        } else {
            textEl.innerHTML = text;
        }
    });
    
    resultsDiv.innerHTML = foundCount > 0 
        ? `Found ${foundCount} result(s)` 
        : 'No results found';
}

// View media files
async function viewMediaFiles(e) {
    e.preventDefault();
    
    // Collect all images from messages
    const images = document.querySelectorAll('.message-image');
    
    if (images.length === 0) {
        await showAlertDialog('No Media', 'No media files found in this conversation.', 'info');
        return;
    }
    
    // Create modal to show media
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header" style="border-bottom: 1px solid #e5e7eb;">
                    <h5 class="modal-title">Media & Files (${images.length})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div class="row g-3">
                        ${Array.from(images).map(img => `
                            <div class="col-md-4">
                                <a href="${img.src}" target="_blank">
                                    <img src="${img.src}" class="img-fluid" style="border-radius: 8px; width: 100%; height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    modal.addEventListener('hidden.bs.modal', function () {
        modal.remove();
    });
}

// Delete chat
async function deleteChat(e) {
    e.preventDefault();
    
    const confirmed = await showConfirmDialog(
        'Delete Conversation',
        'Are you sure you want to delete this entire conversation? All messages will be permanently removed.',
        'danger'
    );
    
    if (!confirmed) return;
    
    fetch(`/messages/delete/${conversationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ route("messages.index") }}';
        } else {
            showAlertDialog('Error', 'Failed to delete chat. Please try again.', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlertDialog('Error', 'Failed to delete chat. Please try again.', 'danger');
    });
}
</script>

<!-- Chat Info Sidebar (slides from right) -->
<div class="chat-info-sidebar" id="chatInfoSidebar">
    <div class="chat-info-header">
        <h5 class="mb-0">Chat Information</h5>
        <button type="button" class="btn-close-sidebar" onclick="toggleChatInfo()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <div class="chat-info-body">
        <!-- Profile Section -->
        <div class="chat-info-section">
            <div class="text-center py-3">
                <div class="avatar-circle-lg mx-auto mb-2">
                    {{ substr($otherUser->name, 0, 1) }}
                </div>
                <h6 class="fw-semibold mb-0">{{ $otherUser->name }}</h6>
                <small class="text-muted">{{ ucfirst($otherUser->role->name ?? 'User') }}</small>
            </div>
        </div>
        
        <!-- Search in Conversation -->
        <div class="chat-info-section">
            <div class="chat-info-item" onclick="focusSearch()">
                <div class="chat-info-icon">
                    <i class="bi bi-search"></i>
                </div>
                <div class="chat-info-text">
                    <div class="chat-info-title">Search in Conversation</div>
                    <div class="chat-info-subtitle">Find messages quickly</div>
                </div>
            </div>
        </div>
        
        <!-- Media & Files -->
        <div class="chat-info-section">
            <div class="chat-info-item" onclick="viewMediaFiles(event)">
                <div class="chat-info-icon">
                    <i class="bi bi-image"></i>
                </div>
                <div class="chat-info-text">
                    <div class="chat-info-title">Media & Files</div>
                    <div class="chat-info-subtitle">View shared photos and files</div>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </div>
        </div>
        
        <!-- Privacy & Support -->
        <div class="chat-info-section">
            <div class="chat-info-section-header">
                Privacy & Support
            </div>
            <div class="chat-info-item" onclick="deleteChat(event)">
                <div class="chat-info-icon danger">
                    <i class="bi bi-trash"></i>
                </div>
                <div class="chat-info-text">
                    <div class="chat-info-title text-danger">Delete Conversation</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for sidebar -->
<div class="chat-info-overlay" id="chatInfoOverlay" onclick="toggleChatInfo()"></div>

@endsection
