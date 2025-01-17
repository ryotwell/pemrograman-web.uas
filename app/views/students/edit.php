<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= e($student->name) ?></title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-gradient-to-r from-blue-50 to-indigo-50">
    
    <?php component('admin-nav'); ?>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit <?= e($student->name) ?></h1>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6">
            <form action="/students/<?= e($student->id) ?>/edit" method="POST" class="space-y-6">
                <!-- name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" value="<?= e($student->name) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="<?= e($student->email) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- phone_number -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" value="<?= e($student->phone_number) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="<?= e($student->address) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- date of birth -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="<?= e($student->date_of_birth) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- tahun angkatan -->
                <div>
                    <label for="tahun_angkatan" class="block text-sm font-medium text-gray-700">Tahun Angkatan</label>
                    <input type="text" name="tahun_angkatan" id="tahun_angkatan" value="<?= e($student->tahun_angkatan) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- semester -->
                <div>
                    <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                    <input type="number" name="semester" id="semester" min="1" max="16" value="<?= e($student->semester) ?>" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- major_id -->
                <div>
                    <label for="major_id" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <select name="major_id" id="major_id" class="mt-2 block w-full px-4 py-3 border border-blue-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <?php foreach ($majors as $major): ?>
                            <option value="<?= e($major->id) ?>" <?= $major->id === $student->major_id ? 'selected' : '' ?>>
                                <?= e($major->name) ?>
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