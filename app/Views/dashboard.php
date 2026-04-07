<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <div class="text-blue-600 text-3xl mb-4"><i class="fas fa-file-contract"></i></div>
        <div class="text-gray-500 text-sm uppercase font-bold mb-1">Total Dokumen</div>
        <div class="text-3xl font-bold text-gray-800"><?= $totalDocs ?></div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <div class="text-green-600 text-3xl mb-4"><i class="fas fa-microchip"></i></div>
        <div class="text-gray-500 text-sm uppercase font-bold mb-1">Knowledge Chunks</div>
        <div class="text-3xl font-bold text-gray-800"><?= $totalChunks ?></div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <div class="text-purple-600 text-3xl mb-4"><i class="fas fa-comments"></i></div>
        <div class="text-gray-500 text-sm uppercase font-bold mb-1">Interaksi Bot</div>
        <div class="text-3xl font-bold text-gray-800"><?= $totalChats ?></div>
    </div>
</div>

<div class="mt-8 bg-[#1e3a8a] text-white p-8 rounded-2xl shadow-lg relative overflow-hidden">
    <div class="relative z-10">
        <h2 class="text-2xl font-bold mb-2">Selamat datang di Gule!</h2>
        <p class="text-blue-100 max-w-lg mb-6">Asisten hukum berbasis AI yang membantu Anda menelusuri database peraturan perundang-undangan dengan mudah dan cepat.</p>
        <a href="/chat" class="bg-white text-blue-900 px-6 py-3 rounded-lg font-bold hover:bg-blue-50 transition-colors">
            Mulai Bertanya <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
    <div class="absolute right-0 top-0 bottom-0 opacity-10 pointer-events-none">
        <i class="fas fa-gavel text-[15rem] -mr-20 -mt-10"></i>
    </div>
</div>
<?= $this->endSection() ?>
