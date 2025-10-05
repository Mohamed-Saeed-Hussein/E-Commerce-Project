{{-- Auto-dismissing Popup Message System --}}
<div id="popup-message-container" class="fixed top-4 right-4 z-50" style="display: none;"></div>

<style>
/* Popup Message Styles */
.popup-message {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    margin-bottom: 12px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
    border-left: 4px solid;
    position: relative;
    overflow: hidden;
    min-width: 300px;
    max-width: 400px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    animation: slideInRight 0.5s ease-out;
}

.popup-success {
    background: #F0F8F4;
    border-left-color: #2ECC71;
    color: #2ECC71;
    border: 1px solid rgba(46, 204, 113, 0.1);
}

.popup-error {
    background: #fef2f2;
    border-left-color: #e74c3c;
    color: #e74c3c;
    border: 1px solid rgba(231, 76, 60, 0.1);
}

.popup-message-content {
    display: flex;
    align-items: center;
    width: 100%;
}

.popup-message-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin-right: 12px;
    flex-shrink: 0;
}

.popup-success .popup-message-icon {
    background-color: #2ECC71;
    color: white;
}

.popup-error .popup-message-icon {
    background-color: #e74c3c;
    color: white;
}

.popup-message-text {
    flex: 1;
    font-weight: 500;
    font-size: 14px;
    line-height: 1.4;
}

/* Animations */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

.popup-message.auto-hide {
    animation: slideOutRight 0.5s ease-in forwards;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .popup-success {
        background: #1a2e1a;
        color: #4ade80;
        border-left-color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.1);
    }
    
    .popup-error {
        background: #2e1a1a;
        color: #f87171;
        border-left-color: #f87171;
        border: 1px solid rgba(248, 113, 113, 0.1);
    }
    
    .popup-success .popup-message-icon {
        background-color: #4ade80;
        color: #000;
    }
    
    .popup-error .popup-message-icon {
        background-color: #f87171;
        color: #000;
    }
}

/* Responsive design */
@media (max-width: 640px) {
    .popup-message {
        min-width: 280px;
        max-width: calc(100vw - 32px);
        margin-right: 16px;
        margin-left: 16px;
    }
    
    #popup-message-container {
        right: 16px;
        left: 16px;
        max-width: none;
    }
}
</style>

<script>
// Auto-dismissing Popup Message System
window.PopupMessage = {
    show: function(message, type = 'success', duration = 3000) {
        const container = document.getElementById('popup-message-container');
        const messageId = 'popup-msg-' + Date.now();
        
        const messageHtml = `
            <div id="${messageId}" class="popup-message popup-${type}">
                <div class="popup-message-content">
                    <div class="popup-message-icon">
                        ${type === 'success' ? 
                            '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                            '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'
                        }
                    </div>
                    <div class="popup-message-text">
                        ${message}
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', messageHtml);
        container.style.display = 'block';
        
        // Auto-hide after duration
        setTimeout(() => {
            const messageEl = document.getElementById(messageId);
            if (messageEl) {
                messageEl.classList.add('auto-hide');
                setTimeout(() => {
                    if (messageEl.parentNode) {
                        messageEl.parentNode.removeChild(messageEl);
                    }
                    // Hide container if no messages left
                    if (container.children.length === 0) {
                        container.style.display = 'none';
                    }
                }, 500);
            }
        }, duration);
    },
    
    success: function(message, duration = 3000) {
        this.show(message, 'success', duration);
    },
    
    error: function(message, duration = 4000) {
        this.show(message, 'error', duration);
    }
};
</script>
