<!DOCTYPE html>
<html lang="th">
<head>
    <?php $title = 'จัดการ Forex - SkyTrade Admin'; include __DIR__ . '/../partials/head.php'; ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <?php $activePage = 'forex'; include __DIR__ . '/partials/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">จัดการคู่สกุลเงิน Forex</h2>
                    <p class="opacity-90">เพิ่ม แก้ไข หรือลบคู่สกุลเงินที่ใช้ในระบบ</p>
                </div>
                <svg class="w-12 h-12 opacity-30" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"></path>
                </svg>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Add New Forex Pair -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">เพิ่มคู่สกุลเงินใหม่</h2>
            </div>
            <div class="p-6">
                <form action="/admin/forex" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="hidden" name="action" value="add_pair">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">สัญลักษณ์</label>
                        <input type="text" name="symbol" required placeholder="เช่น EUR/USD" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อเต็ม</label>
                        <input type="text" name="name" required placeholder="เช่น Euro/US Dollar" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ราคาปัจจุบัน</label>
                        <input type="number" name="current_price" step="0.00001" required placeholder="1.08550" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700 transition">
                            เพิ่มคู่สกุลเงิน
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Forex Pairs List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">คู่สกุลเงินทั้งหมด</h2>
                    <span class="text-sm text-gray-500">ทั้งหมด <?php echo count($forexPairs); ?> คู่</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สัญลักษณ์</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคาปัจจุบัน</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สร้างเมื่อ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($forexPairs as $pair): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($pair->symbol); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($pair->name); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900"><?php echo number_format($pair->current_price, 5); ?></span>
                                        <button onclick="showEditModal(<?php echo $pair->id; ?>, '<?php echo htmlspecialchars($pair->symbol); ?>', '<?php echo htmlspecialchars($pair->name); ?>', <?php echo $pair->current_price; ?>, <?php echo $pair->is_active ? 'true' : 'false'; ?>)" class="ml-2 text-sky-600 hover:text-sky-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $pair->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                        <?php echo $pair->is_active ? 'ใช้งาน' : 'ปิดใช้งาน'; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo date('d/m/Y', strtotime($pair->created_at)); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="showEditModal(<?php echo $pair->id; ?>, '<?php echo htmlspecialchars($pair->symbol); ?>', '<?php echo htmlspecialchars($pair->name); ?>', <?php echo $pair->current_price; ?>, <?php echo $pair->is_active ? 'true' : 'false'; ?>)" class="text-sky-600 hover:text-sky-900">
                                            แก้ไข
                                        </button>
                                        <button onclick="deletePair(<?php echo $pair->id; ?>, '<?php echo htmlspecialchars($pair->symbol); ?>')" class="text-red-600 hover:text-red-900">
                                            ลบ
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">แก้ไขคู่สกุลเงิน</h3>
                <form id="editForm">
                    <input type="hidden" id="editPairId" name="pair_id">
                    <input type="hidden" name="action" value="update_pair">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">สัญลักษณ์</label>
                        <input type="text" id="editSymbol" name="symbol" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อ</label>
                        <input type="text" id="editName" name="name" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">ราคาปัจจุบัน</label>
                        <input type="number" id="editPrice" name="current_price" step="0.00001" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="editActive" name="is_active" class="mr-2">
                            <span class="text-sm font-medium text-gray-700">ใช้งาน</span>
                        </label>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            ยกเลิก
                        </button>
                        <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700">
                            บันทึก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(pairId, symbol, name, price, isActive) {
            document.getElementById('editPairId').value = pairId;
            document.getElementById('editSymbol').value = symbol;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editActive').checked = isActive;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
        }

        function deletePair(pairId, symbol) {
            if (confirm(`คุณต้องการลบคู่สกุลเงิน "${symbol}" ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_pair">
                    <input type="hidden" name="pair_id" value="${pairId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Handle edit form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            const form = document.createElement('form');
            form.method = 'POST';
            for (let [key, value] of formData.entries()) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
</html>
