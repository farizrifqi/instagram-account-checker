# Instagram Account Checker
Untuk detail lebih lanjut silahkan pahami di dalam file nya. Untuk mempermudah, akan saya jelaskan sedikit dibawah ini.

## Panggil class
Masukkan pada awal script
```
require '../class/Instagram.php';
require '../class/Check.php';
```

## Jalankan
Untuk menjalankan cukup mudah, gunakan `check()` contohnya:
```
check('username', 'password');
```

###### Result
Tentang result, dapat di lihat dibawah ini:
```
*error: 0* => **Sukses login. **
*error: 1* => **Username & password benar, namun terkena checkpoint.**
*error: 2* => **Password salah & Gagal login.**
*error: 0* => **Username/email tidak terdaftar.**
```



**Gunakan dengan bijak!**
