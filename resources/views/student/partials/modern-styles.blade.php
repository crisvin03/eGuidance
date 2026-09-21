<style>
/* ========================================
   MODERN STUDENT PORTAL - DESIGN SYSTEM
   ======================================== */

/* Universal Box Sizing & Overflow Fix */
.modern-page-container,
.modern-page-container * {
    box-sizing: border-box;
}

/* Page Container */
.modern-page-container {
    max-width: 100%;
    width: 100%;
    margin: 0 auto;
    padding: 0;
    overflow-x: hidden;
}

/* Page Header */
.modern-page-header {
    background: linear-gradient(135deg, rgba(234, 246, 240, 0.95), rgba(232, 244, 251, 0.9));
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 24px rgba(13, 45, 82, 0.08);
    border: 1px solid rgba(30, 122, 74, 0.15);
}

.modern-page-header-compact {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.modern-page-icon {
    width: 72px;
    height: 72px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.modern-page-icon-pink {
    background: linear-gradient(135deg, #ec4899, #db2777);
    color: white;
}

.modern-page-icon-purple {
    background: linear-gradient(135deg, #a855f7, #9333ea);
    color: white;
}

.modern-page-icon-red {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.modern-page-icon-green {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.modern-page-icon-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.modern-page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 0.35rem;
    letter-spacing: -0.5px;
}

.modern-page-subtitle {
    font-size: 1rem;
    color: var(--text-muted);
    margin: 0;
}

/* Cards */
.modern-card {
    background: linear-gradient(135deg, rgba(240, 249, 245, 0.98), rgba(234, 246, 240, 0.92));
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 4px 24px rgba(13, 45, 82, 0.08);
    border: 1px solid rgba(30, 122, 74, 0.12);
    transition: all 0.3s ease;
    width: 100%;
    max-width: 100%;
    overflow-wrap: break-word;
}

.modern-card:hover {
    box-shadow: 0 8px 32px rgba(13, 45, 82, 0.12);
    transform: translateY(-2px);
}

.modern-card-compact {
    padding: 1.5rem;
}

/* Section Headers */
.modern-section-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(30, 122, 74, 0.12);
}

.modern-section-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.modern-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--navy);
    margin: 0;
}

/* Form Styles */
.modern-form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modern-form-control {
    border-radius: 12px !important;
    border: 1.5px solid rgba(30, 122, 74, 0.15) !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.95rem !important;
    transition: all 0.3s ease !important;
    background: rgba(255, 255, 255, 0.8) !important;
}

.modern-form-control:focus {
    border-color: var(--green) !important;
    box-shadow: 0 0 0 0.2rem rgba(30, 122, 74, 0.15) !important;
    background: white !important;
}

.modern-form-control::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

/* Buttons */
.modern-btn {
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none;
}

.modern-btn-primary {
    background: linear-gradient(135deg, var(--green), var(--green-dark));
    color: white;
    box-shadow: 0 4px 16px rgba(30, 122, 74, 0.3);
}

.modern-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(30, 122, 74, 0.4);
    color: white;
}

.modern-btn-secondary {
    background: rgba(30, 122, 74, 0.08);
    color: var(--green);
    border: 1px solid rgba(30, 122, 74, 0.2);
}

.modern-btn-secondary:hover {
    background: rgba(30, 122, 74, 0.15);
    color: var(--green-dark);
}

.modern-btn-outline {
    background: transparent;
    color: var(--text-dark);
    border: 1.5px solid rgba(30, 122, 74, 0.2);
}

.modern-btn-outline:hover {
    background: rgba(30, 122, 74, 0.05);
    border-color: var(--green);
}

/* List Items */
.modern-list {
    display: flex;
    flex-direction: column;
}

.modern-list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    border-bottom: 1px solid rgba(30, 122, 74, 0.08);
    transition: all 0.2s ease;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.modern-list-item:hover {
    background: linear-gradient(90deg, rgba(30, 122, 74, 0.03), transparent);
    transform: translateX(4px);
}

.modern-list-item:last-child {
    border-bottom: none;
}

.modern-list-item-main {
    flex: 1;
}

.modern-list-item-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.4rem;
}

.modern-list-item-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    font-size: 0.85rem;
    color: var(--text-muted);
}

/* Badges */
.modern-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}

.modern-badge-success {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
}

.modern-badge-warning {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
}

.modern-badge-danger {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
}

.modern-badge-info {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

.modern-badge-purple {
    background: rgba(168, 85, 247, 0.12);
    color: #9333ea;
}

.modern-badge-pink {
    background: rgba(236, 72, 153, 0.12);
    color: #ec4899;
}

/* Empty State */
.modern-empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.modern-empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(30, 122, 74, 0.06));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: var(--green);
    box-shadow: 0 4px 16px rgba(30, 122, 74, 0.15);
}

.modern-empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.75rem;
}

.modern-empty-text {
    font-size: 1rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
    line-height: 1.6;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

/* Alert Boxes */
.modern-alert {
    padding: 1.25rem 1.5rem;
    border-radius: 14px;
    border-left: 4px solid;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.modern-alert-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
    margin-top: 0.1rem;
}

.modern-alert-success {
    background: rgba(16, 185, 129, 0.08);
    border-left-color: #10b981;
}

.modern-alert-success .modern-alert-icon {
    color: #10b981;
}

.modern-alert-info {
    background: rgba(59, 130, 246, 0.08);
    border-left-color: #3b82f6;
}

.modern-alert-info .modern-alert-icon {
    color: #3b82f6;
}

.modern-alert-warning {
    background: rgba(245, 158, 11, 0.08);
    border-left-color: #f59e0b;
}

.modern-alert-warning .modern-alert-icon {
    color: #f59e0b;
}

/* Grid System */
.modern-grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    width: 100%;
    max-width: 100%;
}

.modern-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    width: 100%;
    max-width: 100%;
}

/* Stat Cards */
.modern-stat-card {
    background: linear-gradient(135deg, rgba(240, 249, 245, 0.98), rgba(234, 246, 240, 0.92));
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 20px rgba(13, 45, 82, 0.08);
    border: 1px solid rgba(30, 122, 74, 0.12);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.modern-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    transition: width 0.3s ease;
}

.modern-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.12);
}

.modern-stat-card:hover::before {
    width: 8px;
}

.modern-stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
}

.modern-stat-content {
    flex: 1;
}

.modern-stat-number {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.modern-stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Responsive */
@media (max-width: 992px) {
    .modern-grid-2,
    .modern-grid-3 {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

@media (max-width: 768px) {
    /* Container - Add padding on mobile only */
    .modern-page-container {
        padding: 0 0.75rem;
        overflow-x: hidden;
        max-width: 100%;
    }
    
    /* Page Header */
    .modern-page-header {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    
    .modern-page-header-compact {
        flex-direction: row;
        align-items: center;
        gap: 1rem;
    }
    
    .modern-page-icon {
        width: 48px !important;
        height: 48px !important;
        font-size: 1.25rem !important;
    }
    
    .modern-page-title {
        font-size: 1.35rem !important;
        margin-bottom: 0.25rem;
    }
    
    .modern-page-subtitle {
        font-size: 0.85rem !important;
    }
    
    /* Cards */
    .modern-card {
        padding: 1.25rem;
        border-radius: 16px;
        width: 100%;
        max-width: 100%;
    }
    
    .modern-card-compact {
        padding: 1rem;
    }
    
    /* Grids */
    .modern-grid-2,
    .modern-grid-3 {
        grid-template-columns: 1fr;
        gap: 1rem;
        width: 100%;
    }
    
    /* List Items */
    .modern-list-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
    }
    
    /* Buttons */
    .modern-btn {
        width: 100%;
        justify-content: center;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
    }
    
    /* Section Headers */
    .modern-section-header {
        margin-bottom: 1.25rem;
        padding-bottom: 0.875rem;
        gap: 0.75rem;
    }
    
    .modern-section-icon {
        width: 36px;
        height: 36px;
        font-size: 1rem;
    }
    
    .modern-section-title {
        font-size: 1rem;
    }
    
    /* Stat Cards */
    .modern-stat-card {
        padding: 1.25rem;
    }
    
    .modern-stat-icon {
        width: 48px;
        height: 48px;
        font-size: 1.25rem;
    }
    
    .modern-stat-number {
        font-size: 1.65rem;
    }
    
    .modern-stat-label {
        font-size: 0.8rem;
    }
    
    /* Forms */
    .modern-form-control {
        font-size: 16px !important; /* Prevents zoom on iOS */
        padding: 0.75rem 1rem !important;
    }
    
    .modern-form-label {
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    /* Container */
    .modern-page-container {
        padding: 0 0.5rem;
    }
    
    /* Page Header */
    .modern-page-header {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .modern-page-header-compact {
        gap: 0.75rem;
    }
    
    .modern-page-icon {
        width: 40px !important;
        height: 40px !important;
        font-size: 1.1rem !important;
    }
    
    .modern-page-title {
        font-size: 1.15rem !important;
        letter-spacing: -0.3px;
    }
    
    .modern-page-subtitle {
        font-size: 0.75rem !important;
    }
    
    /* Cards */
    .modern-card {
        padding: 1rem;
        border-radius: 14px;
    }
    
    .modern-card-compact {
        padding: 0.875rem;
    }
    
    /* Buttons */
    .modern-btn {
        padding: 0.625rem 1rem;
        font-size: 0.85rem;
    }
    
    /* Stat Cards */
    .modern-stat-card {
        padding: 1rem;
        gap: 1rem;
    }
    
    .modern-stat-icon {
        width: 42px;
        height: 42px;
        font-size: 1.1rem;
    }
    
    .modern-stat-number {
        font-size: 1.5rem;
    }
    
    .modern-stat-label {
        font-size: 0.75rem;
    }
    
    /* Empty States */
    .modern-empty-icon {
        width: 70px;
        height: 70px;
        font-size: 2rem;
    }
    
    .modern-empty-title {
        font-size: 1.05rem;
    }
    
    .modern-empty-text {
        font-size: 0.875rem;
    }
    
    /* List Items */
    .modern-list-item {
        padding: 0.875rem;
    }
    
    .modern-list-item-title {
        font-size: 0.9rem;
    }
    
    .modern-list-item-meta {
        font-size: 0.75rem;
    }
    
    /* Badges */
    .modern-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.65rem;
    }
    
    /* Section Headers */
    .modern-section-header {
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .modern-section-icon {
        width: 32px;
        height: 32px;
        font-size: 0.9rem;
    }
    
    .modern-section-title {
        font-size: 0.95rem;
    }
}
</style>
