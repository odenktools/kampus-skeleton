# Kampus Skeleton

Dipergunakan untuk Sample Rest API.

# Fitur

- [x] PHP 5.6 dan Laravel framework 5.4.x
- [x] Menggunakan tanggal ISO8601
- [x] [Mengikuti Google JSON Style Guide](https://google.github.io/styleguide/jsoncstyleguide.xml)
- [x] MySQL dan PostgreSQL support
- [x] Sample Image processing
- [x] Sample penggunaan database (migration, one to many, many to one, many to many)
- [x] Sample response CRUD REST API yang simple (Modul Berita)
- [x] Sample response CRUD REST API yang advanced (digunakan untuk project base) (Modul Kampus)
- [x] Sample response pagination
- [x] Sample kirim email
- [x] Sample penggunaan **Event Driven**
- [x] Project CodeBase

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
            "image_url": "http://local.laravel.com/storage/images/kampus/lpkia.png",
            "post_date": "2019-06-04T07:00:00+07:00",
            "is_active": true,
            "created_at": "2019-05-04T13:31:20+07:00",
            "updated_at": "2019-05-04T13:31:20+07:00"
        },
        {
            "judul_berita": "Rossi Menang di Assen Belanda",
            "tipe_berita": "news",
            "isi_berita": "Rossi Menang di Assen Belanda yang berujung pada naiknya peringkat kelasemen",
            "image_url": "http://local.laravel.com/storage/",
            "post_date": "2019-06-04T07:00:00+07:00",
            "is_active": true,
            "created_at": "2019-06-04T19:41:33+07:00",
            "updated_at": "2019-06-04T19:41:33+07:00"
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
    "message": "Success",
    "results": [
        {
            "judul_berita": "Rossi Menang di Assen Belanda2",
            "tipe_berita": "news",
            "is_active": true,
            "isi_berita": "Rossi Menang di Assen Belanda yang beruj2ung pada naiknya peringkat kelasemen",
            "post_date": "2019-06-20T07:00:00+07:00",
            "updated_at": "2019-06-20T23:02:39+07:00",
            "created_at": "2019-06-20T23:02:39+07:00",
            "id": 12
        }
    ]
}
```

**Response Gagal**

```json
{
    "message": "Error",
    "results": [
        "The judul berita has already been taken."
    ]
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
    "message": "Success",
    "results": [
        {
            "id": 12,
            "judul_berita": "Rossi Menang di Assen Belanda3",
            "tipe_berita": "news",
            "isi_berita": "Rossi Menang di Assen Belanda yang berujung pada naiknya peringkat kelasemen",
            "post_date": "2019-06-20T07:00:00+07:00",
            "is_active": true,
            "created_at": "2019-06-20T23:02:39+07:00",
            "updated_at": "2019-06-20T23:05:26+07:00"
        }
    ]
}
```

**Response Gagal**

```json
{
    "message": "Error",
    "results": [
        "The is active field is required."
    ]
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
        "api_version": "1.0",
        "method": "POST",
        "message": "Validation error.",
        "errors": [
            "The handphone admin field contains an invalid number."
        ]
    },
    "data": {
        "message": "errors",
        "items": []
    }
}
```

**Error**

```json
{
    "meta": {
        "code": 200,
        "api_version": "1.0",
        "method": "POST",
        "message": "Success"
    },
    "errors": [],
    "pageinfo": {},
    "data": {
        "message": "apikey is zFiA8CBsrhijSGymnHcOa3A7J75XvChW",
        "items": [
            {
                "nama_kampus": "parahyangan",
                "kode_kampus": "parahyangan",
                "no_telephone": "0896710110",
                "kota": "bandung",
                "alamat": "alamat",
                "deskripsi": "deskripsi",
                "updated_at": "2019-06-03 15:25:31",
                "created_at": "2019-06-03 15:25:31",
                "id": 3
            }
        ]
    }
}
```

```
DELETE FROM user_roles WHERE user_id = 2;
DELETE FROM users WHERE id = 2;
DELETE FROM kampus WHERE id = 2;

ALTER TABLE kampus AUTO_INCREMENT = 1;
ALTER TABLE user_roles AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 1;
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

#### Membuat event baru

```bash
php artisan event:generate
```

#### Benchmarking

```bash
curl --request GET --url http://local.kampus.com/api/v1/berita --header 'Accept: application/json' --header 'Authorization: Bearer Ctbm2oNWbhPbfmpW60yjbcvEmwXrJr4H'
```

```bash
ab -k -c 10 -n 100 -T application/json -H "Authorization: Bearer Ctbm2oNWbhPbfmpW60yjbcvEmwXrJr4H" http://local.kampus.com/api/v1/berita
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
