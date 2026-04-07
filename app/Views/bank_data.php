<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Dokumen Hukum</h2>
        <a href="/upload" class="bg-[#1e3a8a] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-900 transition-colors">
            <i class="fas fa-plus mr-2"></i> Tambah Dokumen
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                <tr>
                    <th class="px-6 py-4 font-semibold">Judul</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 font-semibold">Tahun</th>
                    <th class="px-6 py-4 font-semibold">Tgl Upload</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($documents as $doc): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-800 font-medium"><?= esc($doc['title']) ?></td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase">
                                <?= esc($doc['category']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600"><?= esc($doc['year']) ?></td>
                        <td class="px-6 py-4 text-gray-500 text-sm"><?= date('d M Y', strtotime($doc['created_at'])) ?></td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-gray-400 hover:text-blue-600 transition-colors mr-3" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="/upload/delete/<?= $doc['id'] ?>" class="text-gray-400 hover:text-red-600 transition-colors" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($documents)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada dokumen yang diunggah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
