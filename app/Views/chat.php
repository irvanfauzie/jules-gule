<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="flex flex-col h-[calc(100vh-180px)]">
    <!-- Chat Messages -->
    <div id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-white rounded-xl shadow-sm border border-gray-100 mb-4">
        <?php foreach ($history as $chat): ?>
            <?php if ($chat['sender'] == 'user'): ?>
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none max-w-xl">
                        <?= esc($chat['message']) ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="flex justify-start">
                    <div class="bg-gray-100 text-gray-800 p-4 rounded-2xl rounded-tl-none max-w-xl shadow-sm border border-gray-200">
                        <div class="prose prose-sm max-w-none">
                            <?= nl2br(esc($chat['message'])) ?>
                        </div>
                        <?php if (!empty($chat['references'])): ?>
                            <div class="mt-3 pt-3 border-t border-gray-200 text-xs text-blue-700 font-semibold italic">
                                <i class="fas fa-book mr-1"></i> Sumber: <?= esc($chat['references']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (empty($history)): ?>
            <div class="text-center py-20 text-gray-400">
                <i class="fas fa-robot text-6xl mb-4 opacity-20"></i>
                <p>Halo! Saya adalah asisten Gule. Ada yang bisa saya bantu terkait dokumen hukum?</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Input Area -->
    <form id="chat-form" class="bg-white p-2 rounded-2xl shadow-md flex items-center border border-gray-200">
        <?= csrf_field() ?>
        <input type="text" id="message-input" class="flex-1 px-4 py-3 outline-none rounded-l-2xl text-gray-700" placeholder="Tanyakan sesuatu tentang peraturan...">
        <button type="submit" class="bg-[#1e3a8a] text-white p-3 rounded-xl hover:bg-blue-900 transition-colors w-12 h-12 flex items-center justify-center">
            <i class="fas fa-paper-plane"></i>
        </button>
    </form>
</div>

<script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('message-input');
    const container = document.getElementById('chat-container');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const msg = input.value.trim();
        if (!msg) return;

        // Add user message to UI
        const userHtml = `
            <div class="flex justify-end">
                <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none max-w-xl">
                    ${escapeHtml(msg)}
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', userHtml);
        input.value = '';
        container.scrollTop = container.scrollHeight;

        // Add loading indicator
        const loadingId = 'loading-' + Date.now();
        const loadingHtml = `
            <div id="${loadingId}" class="flex justify-start">
                <div class="bg-gray-100 p-4 rounded-2xl rounded-tl-none border border-gray-200">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', loadingHtml);
        container.scrollTop = container.scrollHeight;

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('input[name="csrf_test_name"]').value
                },
                body: 'message=' + encodeURIComponent(msg) + '&csrf_test_name=' + document.querySelector('input[name="csrf_test_name"]').value
            });
            const data = await response.json();

            // Remove loading
            document.getElementById(loadingId).remove();

            // Add bot response
            const botHtml = `
                <div class="flex justify-start">
                    <div class="bg-gray-100 text-gray-800 p-4 rounded-2xl rounded-tl-none max-w-xl shadow-sm border border-gray-200">
                        <div class="prose prose-sm max-w-none">
                            ${escapeHtml(data.message).replace(/\n/g, '<br>')}
                        </div>
                        ${data.references && data.references.length ? `
                            <div class="mt-3 pt-3 border-t border-gray-200 text-xs text-blue-700 font-semibold italic">
                                <i class="fas fa-book mr-1"></i> Sumber: ${data.references.map(r => escapeHtml(r)).join(', ')}
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', botHtml);
            container.scrollTop = container.scrollHeight;

        } catch (error) {
            console.error('Error:', error);
            document.getElementById(loadingId).innerHTML = '<div class="text-red-500 italic">Maaf, terjadi kesalahan teknis.</div>';
        }
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
</script>
<?= $this->endSection() ?>
