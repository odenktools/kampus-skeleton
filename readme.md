# Kampus Skeleton

Dipergunakan untuk Sample Rest API

# Cara Install

```bash
cp .env.example .env

composer install
```

Buat database

Menggunakan **MySQL**

```sql
DROP DATABASE IF EXISTS laravel_kampus;
CREATE DATABASE laravel_kampus
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
```

Menggunakan **PostgreSQL**

```bash
su - postgres
createdb laravel_kampus
```

Migrasi Database

```bash
php artisan migrate --seed
```

# Sample RestApi

Rubah **http://local.kampus.com** dengan domain / IP milik Anda.

**List Berita**

```bash
curl --request GET -url http://local.kampus.com/api/v1/berita
```

```json
{
    "results": [
        {
            "judul_berita": "Wow Mahasiswa LPKIA Mendapatkan Juara Olimpiade Teknologi",
            "tipe_berita": "pendidikan",
            "isi_berita": "Wow mahasiswa LPKIA mendapatkan juara olimpiade teknologi pada hari kamis 09 September 2019 yang diselengarakan oleh...",
            "image_url": "http://local.kampus.com/storage/images/kampus/lpkia.png",
            "post_date": "2019-05-20 00:00:00",
            "is_active": true
        },
        {
            "judul_berita": "Rossi Menang di Assen Belanda3",
            "tipe_berita": "news",
            "isi_berita": "Rossi Menang di Assen Belanda yang berujung pada naiknya peringkat kelasemen",
            "image_url": "http://local.kampus.com/storage/images/berita/7tY99ZJm2PaHlJ3QnqgVbOZPO0xmmi5wvmyl8mri.png",
            "post_date": "2019-05-20 00:00:00",
            "is_active": true
        }
    ]
}
```

**Insert Berita**

```bash
curl --request POST \
  --url http://local.kampus.com/api/v1/berita/insert \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --header 'content-type: multipart/form-data;' \
  --form 'judul_berita=Rossi Menang di Assen Belanda' \
  --form tipe_berita=news \
  --form is_active=1 \
  --form 'isi_berita=Rossi Menang di Assen Belanda yang berujung pada naiknya peringkat kelasemen' \
  --form 'thumbnail=file=@/opt/pictures/{{IMAGE_WANT_TO_UPLOAD}}.jpg'
```

**Response Sukses**

```json
{
    "meta": {
        "code": 200,
        "message": "Operation successfully executed."
    },
    "data": [
        "success"
    ]
}
```

**Response Gagal**

```json
{
    "meta": {
        "code": 422,
        "message": "Error executing request.",
        "errors": [
            "The judul berita has already been taken.",
            "The is active field is required."
        ]
    },
    "data": []
}
```

**Update Berita**

```bash
curl --request POST \
  --url http://local.kampus.com/api/v1/berita/update/1 \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --header 'content-type: multipart/form-data;' \
  --form 'judul_berita=Rossi Menang di Assen Belanda Updated' \
  --form tipe_berita=news \
  --form is_active=1 \
  --form 'isi_berita=Rossi Menang di Assen Belanda yang berujung pada naiknya peringkat kelasemen' \
  --form 'thumbnail=file=@/opt/pictures/{{IMAGE_WANT_TO_UPLOAD}}.jpg'
```

**Response Sukses**

```json
{
    "meta": {
        "code": 200,
        "message": "Operation successfully executed."
    },
    "data": [
        "success"
    ]
}
```

**Response Gagal**

```json
{
    "meta": {
        "code": 422,
        "message": "Error executing request.",
        "errors": [
            "The is active field is required."
        ]
    },
    "data": []
}
```

**Registrasi Kampus**

```bash
curl --request POST \
  --url http://local.kampus.com/api/v1/kampus/register \
  --header 'content-type: multipart/form-data;' \
  --form nama_kampus=NAMA_KAMPUS_ANDA \
  --form no_telephone=NO_TELP_KAMUS_ANDA \
  --form nama_admin=HALLO \
  --form telephone_admin=08983289838 \
  --form email_admin=admin@kampusanda.com \
  --form kota=bandung \
  --form alamat=ALAMAT_KAMPUS_ANDA \
  --form deskripsi=DESKRIPSI_KAMPUS_ANDA
```

**Error Validasi Nomor Handphone**

```json
{
    "meta": {
        "code": 422,
        "message": "Error executing request.",
        "errors": [
            "The handphone admin field contains an invalid number."
        ]
    },
    "data": []
}
```

**Error Duplikat Data**

```json
{
    "meta": {
        "code": 422,
        "message": "Error executing request.",
        "errors": [
            "The nama kampus has already been taken.",
            "The handphone admin has already been taken.",
            "The email admin has already been taken."
        ]
    },
    "data": []
}
```

# Development

#### Membuat Migrasi Baru

```bash
php artisan make:migration create_visitors_table
php artisan make:migration create_dosens_table
php artisan make:migration create_mahasiswas_table
```

#### Membuat Seeder Baru

```bash
php artisan make:seeder UsersTableSeeder
```

#### Generate AutoComplete untuk PHPStorm

```bash
php artisan ide-helper:generate
php artisan ide-helper:meta
```

# LICENSE

MIT License

Copyright (c) 2019 odenktools

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
