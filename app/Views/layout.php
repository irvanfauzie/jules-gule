<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gule - Gerbang Undang-undang Legal Elektronik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#1e3a8a] text-white flex-shrink-0">
            <div class="p-6 text-2xl font-bold flex items-center">
                <i class="fas fa-gavel mr-3"></i> GULE
            </div>
            <nav class="mt-6">
                <a href="/" class="flex items-center py-3 px-6 hover:bg-blue-800 transition-colors <?= current_url() == base_url() ? 'bg-blue-800' : '' ?>">
                    <i class="fas fa-home mr-3 w-5 text-center"></i> Dashboard
                </a>
                <a href="/upload" class="flex items-center py-3 px-6 hover:bg-blue-800 transition-colors <?= str_contains(current_url(), 'upload') ? 'bg-blue-800' : '' ?>">
                    <i class="fas fa-upload mr-3 w-5 text-center"></i> Upload Dokumen
                </a>
                <a href="/bank-data" class="flex items-center py-3 px-6 hover:bg-blue-800 transition-colors <?= str_contains(current_url(), 'bank-data') ? 'bg-blue-800' : '' ?>">
                    <i class="fas fa-database mr-3 w-5 text-center"></i> Bank Data
                </a>
                <a href="/chat" class="flex items-center py-3 px-6 hover:bg-blue-800 transition-colors <?= str_contains(current_url(), 'chat') ? 'bg-blue-800' : '' ?>">
                    <i class="fas fa-robot mr-3 w-5 text-center"></i> Chatbot
                </a>
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t border-blue-800 text-xs text-blue-300">
                &copy; 2026 Gule - Legal AI Assistant
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-auto bg-gray-50">
            <!-- Header -->
            <header class="bg-white shadow-sm py-4 px-8 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800"><?= $title ?? 'Dashboard' ?></h1>
                <div class="flex items-center">
                    <span class="mr-4 text-sm text-gray-600">Admin Hukum</span>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</body>
</html>
