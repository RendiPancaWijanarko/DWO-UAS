DASHBOARD DATA WAREHOUSE

Source code yang kami sediakan disini adalah sebuah dashboard data warehouse yang bertujuan untuk menyajikan data dari warehouse secara visual dan interaktif berdasarkan database AdventureWorks pada skema Sales dan Production.


PERSYARATAN SYSTEM

Sistem Operasi  : Windows 8 atau lebih, macOS, atau Linux
Browser Web     : Google Chrome, Mozilla Firefox, Microsoft Bing
Local Host      : Xampp Control Panel
Modul           : Apache, MySQL, Tomcat (Mondrian)
Database MySQL versi 7 atau yang lebih baru


INSTALASI

1. Silahkan unduh repository ini
2. Extract file zip menggunakan 7zip atau WinRar
3. Pindahkan folder "Dwo_AdvWorks" ke dalam directory C:\xampp\htdocs
4. Extract file "mondrian_dwo.rar" dan pindahkan ke dalam directory C:\xampp\tomcat\webapps 
5. Buka software Xampp Control Panel dan jalankan modul Apache, MySQL, dan Tomcat (Lakukan instalasi terlebih dahulu jika anda belum memiliki nya)
6. Buka Browser kesayangan anda dan ketikan http://localhost/phpmyadmin/ lalu tekan enter
7. Masukkan username dan password database localhost anda, untuk default biasanya memiliki credentials 'root' sebagai username dan password yang kosong
8. Buat sebuah database baru dengan nama 'dwo_uas' (WAJIB karena pemrograman menggunakan framework CodeIgniter yang mengharuskan setiap elemen yang dipanggil sesuai dengan nama elemen yang sudah diinisiasi sebelumnya)
9. Lakukan import database 'dwo_uas.sql' pada folder 'Database' (Jika gagal, artinya phpmyadmin anda terkena limit size, lakukan kompresi terhadap file 'dwo_uas.sql' dan ulangi cara nomor 7)
10. Masuk ke dalam folder "Dwo_AdvWorks" yang sudah anda download
11. Setelah instalasi berhasil, anda bisa melanjutkan ke tahap PENGGUNAAN APLIKASI

PENGGUNAAN APLIKASI

1. Buka website berbasis localhost anda dengan mengetikan link berikut pada browser kesayangan anda : http://localhost/Dwo_AdvWorks 
2. Lakukan login dengan cara memasukkan akun yang valid sesuai yang tertera pada database. Berikut akun yang bisa anda gunakan :
username  : rendi
password  : rendipanca
3. Setelah berhasil masuk, anda sudah bisa mengoperasikan dashboard warehouse ataupun sekedar melihat visualisasi data dan menganalisis nya.
4. Anda bisa melakukan penyimpanan grafik yang tersedia ke dalam PNG, JPEG, PDF, SVG, CSV, hingga file Excel (XLS)
5. Setelah aktifitas selesai, silahkan lakukan logout.


KONTAK

Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami melalui email di 21082010016@student.upnjatim.ac.id
Terima kasih telah menggunakan aplikasi dashboard kami!
