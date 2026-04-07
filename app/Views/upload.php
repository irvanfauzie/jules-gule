<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Upload Dokumen Hukum Baru</h2>

        <form action="/upload/process" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen</label>
                <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Contoh: UU No 11 Tahun 2020 tentang Cipta Kerja">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="Undang-undang">Undang-undang</option>
                        <option value="Peraturan Pemerintah">Peraturan Pemerintah</option>
                        <option value="Perda">Perda</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="2023">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">File PDF</label>
                <div id="drop-area" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition-colors cursor-pointer bg-gray-50">
                    <input type="file" name="document" id="fileElem" accept=".pdf" class="hidden" required>
                    <div class="text-blue-500 text-4xl mb-2"><i class="fas fa-file-pdf"></i></div>
                    <p class="text-sm text-gray-600 mb-2">Drag & drop file PDF Anda di sini, atau <span class="text-blue-600 font-semibold">klik untuk memilih</span></p>
                    <p class="text-xs text-gray-400">Ukuran maksimal 20MB</p>
                    <div id="file-info" class="mt-4 text-sm font-semibold text-blue-800 hidden"></div>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1e3a8a] text-white py-3 rounded-lg font-bold hover:bg-blue-900 transition-colors flex items-center justify-center">
                <i class="fas fa-cloud-upload-alt mr-2"></i> Proses Dokumen
            </button>
        </form>
    </div>
</div>

<script>
    const dropArea = document.getElementById('drop-area');
    const fileElem = document.getElementById('fileElem');
    const fileInfo = document.getElementById('file-info');

    dropArea.addEventListener('click', () => fileElem.click());

    fileElem.addEventListener('change', () => {
        if (fileElem.files.length) {
            fileInfo.textContent = "File terpilih: " + fileElem.files[0].name;
            fileInfo.classList.remove('hidden');
        }
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('border-blue-500', 'bg-blue-50'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('border-blue-500', 'bg-blue-50'), false);
    });

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        fileElem.files = files;
        if (files.length) {
            fileInfo.textContent = "File terpilih: " + files[0].name;
            fileInfo.classList.remove('hidden');
        }
    }
</script>
<?= $this->endSection() ?>
