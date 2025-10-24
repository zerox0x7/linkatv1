<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة الصفحات الثابتة</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Cairo', 'Tajawal', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        input:focus,
        textarea:focus,
        select:focus,
        button:focus {
            outline: none;
        }

        .rounded-button {
            border-radius: 8px;
        }

        /* Toggle Switch Styles */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #374151;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        input:checked + .slider {
            background-color: #00C8B3;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider:hover {
            opacity: 0.8;
        }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#00e5c9",
                        secondary: "#6b46c1"
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
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

<body class="min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        @include('themes.admin.parts.sidebar')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            @include('themes.admin.parts.header')
            
            <!-- Page Content -->
            @livewire('static-pages')
        </div>
    </div>
</body>

</html>
