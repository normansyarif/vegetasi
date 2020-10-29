## Cara instal

- pip install pandas, sklearn, numpy
- Buka /laravel/app/Http/Controllers/PageController.php
- Sesuaikan variabel $pythonBinary dengan path executable python yg terinstal di komputer (absolute path). Misal "C:\Users\User\AppData\Local\Programs\Python\Python36\python.exe"
- Masih di file yang sama, sesuaikan variabel $pythonProjectPath dengan folder pyproject yang ada di /laravel/public/ (absolute path). Misal C:\xampp\htdocs\laravel\public\pyproject\\.
- Buka /laravel/public/pyproject/full.py. Sesuaikan variabel "absolutePath" dengan path folder pyproject yang ada di /laravel/public/ (absolute path).
- Lakukan hal yang sama pada /laravel/public/pyproject/train.py.
- Akses url laravel/public pada browser.
- Jika terdapat ModuleNotFoundError, pip install modul yg bersangkutan, kemudian reload halaman.
