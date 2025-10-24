<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المتجر - تخصيص الفوتر</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0f172a;
            color: #fff;
        }

        /* Toggle Switch Styles */
        .toggle-switch:checked + .toggle-bg {
            background: linear-gradient(135deg, #00e5bb, #00c4a7);
        }
        
        .toggle-switch:checked + .toggle-bg .toggle-dot {
            transform: translateX(-1rem);
        }
        
        .toggle-switch:focus + .toggle-bg {
            box-shadow: 0 0 0 3px rgba(0, 229, 187, 0.25);
        }

        /* Drag and Drop Styles */
        .dragging {
            opacity: 0.8;
            background: linear-gradient(135deg, #1e293b, #334155) !important;
            box-shadow: 0 4px 20px rgba(0, 229, 187, 0.2);
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        .drag-over {
            border: 2px dashed #00e5bb;
            background: rgba(0, 229, 187, 0.05);
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        /* Disabled Content */
        .content-disabled {
            opacity: 0.5;
            pointer-events: none;
            filter: grayscale(0.5);
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #00e5bb, #00c4a7);
            color: #0f172a;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            z-index: 50;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 4px 20px rgba(0, 229, 187, 0.3);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .draggable-item {
            cursor: move;
        }

        .primary-color {
            color: #00e5bb;
        }

        .primary-bg {
            background-color: #00e5bb;
        }

        .sidebar-item.active {
            background-color: rgba(0, 229, 187, 0.1);
            border-right: 3px solid #00e5bb;
        }

        .sidebar-item:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .section-card {
            background-color: #1e293b;
            border-radius: 8px;
        }

        .section-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        input[type="checkbox"] {
            appearance: none;
            width: 3.5rem;
            height: 1.75rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            position: relative;
            transition: all 0.3s;
        }

        input[type="checkbox"]::before {
            content: "";
            position: absolute;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            top: 0.25rem;
            right: 1.9rem;
            background-color: white;
            transition: all 0.3s;
        }

        input[type="checkbox"]:checked {
            background-color: #00e5bb;
        }

        input[type="checkbox"]:checked::before {
            right: 1.5rem;
        }

        .custom-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .custom-input:focus {
            border-color: #00e5bb;
            outline: none;
        }

        .color-picker {
            appearance: none;
            width: 2rem;
            height: 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .color-picker::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        .color-picker::-webkit-color-swatch {
            border: none;
            border-radius: 4px;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00e5bb',
                        secondary: '#0f172a'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>

   <!-- CSS للتحكم في القوائم المنسدلة -->
    <style>
        .s-dropdown-content {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .s-dropdown-content.show {
            display: block;
            opacity: 1;
            max-height: 500px;
        }

        .s-dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .s-dropdown-toggle:hover {
            color: #10b981;
        }

        .s-transform.rotate-180 {
            transform: rotate(180deg);
        }
    </style>

</head>

<body class="min-h-screen flex">
 @include('themes.admin.parts.sidebar')
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar -->
      @include('themes.admin.parts.header')
      @livewire('footer-customizer')
    </div>
    <div id="toast" class="toast" role="alert"></div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast');
            
            // Toast notification function
            function showToast(message) {
                toast.textContent = message;
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }

            // Toggle functionality for each section
            const toggles = [
                { toggle: 'footerToggle', content: 'footerSettings' },
                { toggle: 'footerLinksToggle', content: 'footerLinksContent' },
                { toggle: 'socialLinksToggle', content: 'socialLinksContent' },
                { toggle: 'contactToggle', content: 'contactContent' }
            ];
            
            toggles.forEach(({ toggle, content }) => {
                const toggleElement = document.getElementById(toggle);
                const contentElement = document.getElementById(content);
                
                if (toggleElement && contentElement) {
                    toggleElement.addEventListener('change', function() {
                        if (this.checked) {
                            contentElement.classList.remove('content-disabled');
                        } else {
                            contentElement.classList.add('content-disabled');
                        }
                    });
                }
            });
            
            // Add footer link functionality
            const addFooterLinkBtn = document.getElementById('addFooterLink');
            const footerLinksContainer = document.getElementById('footerLinksContent');
            
            if (addFooterLinkBtn && footerLinksContainer) {
                addFooterLinkBtn.addEventListener('click', function() {
                    const newLink = document.createElement('div');
                    newLink.className = 'bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] flex justify-between items-center draggable-item shadow-md hover:shadow-lg transition-shadow duration-300';
                    newLink.draggable = true;
                    newLink.innerHTML = `
                        <div class="flex items-center gap-3">
                            <button class="text-gray-400 hover:text-red-500 transition-colors duration-300 delete-btn">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="text-gray-400 hover:text-primary transition-colors duration-300 drag-handle cursor-grab">
                                <i class="ri-drag-move-line"></i>
                            </button>
                        </div>
                        <div class="flex-1 mr-4">
                            <input type="text" class="bg-[#111827] border border-[#2a3548] text-white w-full p-2 rounded text-sm mb-2 focus:border-primary focus:outline-none" 
                                   placeholder="نص الرابط" value="">
                            <input type="text" class="bg-[#111827] border border-[#2a3548] text-white w-full p-2 rounded text-sm focus:border-primary focus:outline-none" 
                                   placeholder="URL الرابط" value="">
                        </div>
                    `;
                    footerLinksContainer.appendChild(newLink);
                    
                    // Add delete functionality
                    newLink.querySelector('.delete-btn').addEventListener('click', function() {
                        newLink.remove();
                        showToast('تم حذف الرابط بنجاح');
                    });
                    
                    initDragAndDrop();
                    showToast('تم إضافة رابط جديد');
                });
            }
            
            // Add social media link functionality
            const addSocialLinkBtn = document.getElementById('addSocialLink');
            const socialLinksContainer = document.getElementById('socialLinksContent');
            
            if (addSocialLinkBtn && socialLinksContainer) {
                addSocialLinkBtn.addEventListener('click', function() {
                    const newSocialLink = document.createElement('div');
                    newSocialLink.className = 'bg-[#0f1623] rounded-lg p-4 border border-[#2a3548] flex justify-between items-center draggable-item shadow-md hover:shadow-lg transition-shadow duration-300';
                    newSocialLink.draggable = true;
                    newSocialLink.innerHTML = `
                        <div class="flex items-center gap-3">
                            <button class="text-gray-400 hover:text-red-500 transition-colors duration-300 delete-btn">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <button class="text-gray-400 hover:text-primary transition-colors duration-300 drag-handle cursor-grab">
                                <i class="ri-drag-move-line"></i>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 flex-1 mr-4">
                            <select class="bg-[#111827] border border-[#2a3548] text-white p-2 rounded text-sm focus:border-primary focus:outline-none">
                                <option value="ri-facebook-fill">Facebook</option>
                                <option value="ri-twitter-fill">Twitter</option>
                                <option value="ri-instagram-line">Instagram</option>
                                <option value="ri-youtube-fill">YouTube</option>
                                <option value="ri-linkedin-fill">LinkedIn</option>
                                <option value="ri-whatsapp-line">WhatsApp</option>
                            </select>
                            <input type="text" class="bg-[#111827] border border-[#2a3548] text-white flex-1 p-2 rounded text-sm focus:border-primary focus:outline-none" 
                                   placeholder="URL الرابط" value="">
                        </div>
                    `;
                    socialLinksContainer.appendChild(newSocialLink);
                    
                    // Add delete functionality
                    newSocialLink.querySelector('.delete-btn').addEventListener('click', function() {
                        newSocialLink.remove();
                        showToast('تم حذف رابط التواصل الاجتماعي بنجاح');
                    });
                    
                    initDragAndDrop();
                    showToast('تم إضافة رابط تواصل اجتماعي جديد');
                });
            }
            
            // Initialize delete buttons for existing items
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const item = this.closest('.draggable-item');
                    if (item) {
                        item.remove();
                        if (item.closest('#footerLinksContent')) {
                            showToast('تم حذف الرابط بنجاح');
                        } else if (item.closest('#socialLinksContent')) {
                            showToast('تم حذف رابط التواصل الاجتماعي بنجاح');
                        }
                    }
                });
            });
            
            // Drag and drop functionality
            let draggedItem = null;
            
            function initDragAndDrop() {
                const draggableItems = document.querySelectorAll('.draggable-item');
                
                draggableItems.forEach(item => {
                    item.removeEventListener('dragstart', handleDragStart);
                    item.removeEventListener('dragend', handleDragEnd);
                    item.removeEventListener('dragover', handleDragOver);
                    item.removeEventListener('drop', handleDrop);
                    item.removeEventListener('dragenter', handleDragEnter);
                    item.removeEventListener('dragleave', handleDragLeave);
                    
                    item.addEventListener('dragstart', handleDragStart);
                    item.addEventListener('dragend', handleDragEnd);
                    item.addEventListener('dragover', handleDragOver);
                    item.addEventListener('drop', handleDrop);
                    item.addEventListener('dragenter', handleDragEnter);
                    item.addEventListener('dragleave', handleDragLeave);
                });
            }
            
            function handleDragStart(e) {
                draggedItem = this;
                this.classList.add('dragging');
                document.body.style.cursor = 'grabbing';
            }
            
            function handleDragEnd(e) {
                this.classList.remove('dragging');
                document.body.style.cursor = '';
                showToast('تم تغيير ترتيب العناصر بنجاح');
            }
            
            function handleDragOver(e) {
                e.preventDefault();
            }
            
            function handleDragEnter(e) {
                e.preventDefault();
                if (this !== draggedItem && this.classList.contains('draggable-item')) {
                    this.classList.add('drag-over');
                }
            }
            
            function handleDragLeave(e) {
                this.classList.remove('drag-over');
            }
            
            function handleDrop(e) {
                e.preventDefault();
                if (this !== draggedItem && this.classList.contains('draggable-item')) {
                    const container = this.parentNode;
                    const allItems = Array.from(container.querySelectorAll('.draggable-item'));
                    const draggedIndex = allItems.indexOf(draggedItem);
                    const droppedIndex = allItems.indexOf(this);
                    
                    if (draggedIndex < droppedIndex) {
                        container.insertBefore(draggedItem, this.nextSibling);
                    } else {
                        container.insertBefore(draggedItem, this);
                    }
                }
                this.classList.remove('drag-over');
            }
            
            // Initialize drag and drop for existing items
            initDragAndDrop();
            
            // Save button functionality
            document.querySelector('.bg-gradient-to-r.from-primary.to-secondary').addEventListener('click', function() {
                showToast('تم حفظ إعدادات الفوتر بنجاح');
            });
        });
    </script>
</body>

</html>
