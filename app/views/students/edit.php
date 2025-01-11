<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($student->name) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-indigo-50">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex">
                    <a href="#" class="text-xl font-bold text-indigo-600 hover:text-indigo-800 transition duration-300">Student Management</a>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/logout" class="text-gray-600 hover:text-indigo-600 transition duration-300">Logout</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden mobile-menu md:hidden">
            <a href="/logout" class="block py-2 px-4 text-gray-600 hover:bg-indigo-50">Logout</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit <?= htmlspecialchars($student->name) ?></h1>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="/students/<?= htmlspecialchars($student->id) ?>/edit" method="POST" class="space-y-6">
                <!-- name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($student->name) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($student->email) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- phone_number -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" value="<?= htmlspecialchars($student->phone_number) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="<?= htmlspecialchars($student->address) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- date of birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="<?= htmlspecialchars($student->date_of_birth) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- tahun angkatan -->
                <div>
                    <label for="tahun_angkatan" class="block text-sm font-medium text-gray-700">Tahun Angkatan</label>
                    <input type="text" name="tahun_angkatan" id="tahun_angkatan" value="<?= htmlspecialchars($student->tahun_angkatan) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <input type="number" name="semester" id="semester" min="1" max="16" value="<?= htmlspecialchars($student->semester) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- major_id -->
                <div>
                    <label for="major_id" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <select name="major_id" id="major_id" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <?php foreach ($majors as $major): ?>
                            <option value="<?= htmlspecialchars($major->id) ?>" <?= $major->id === $student->major_id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($major->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select name="gender" id="gender" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="Male" <?= $student->gender === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= $student->gender === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="/students" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Student
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        const mobileMenu = document.querySelector('.mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.matches('button')) {
                const dropdowns = document.getElementsByClassName('absolute');
                for (let dropdown of dropdowns) {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
</body>
</html>