# Web App Management Keuangan — Product Prompt (Laravel Version)

## Objective
Bangun aplikasi web management keuangan menggunakan Laravel (Fullstack) dengan Tailwind CSS dan database MySQL.

Aplikasi harus:
- Mobile-first (prioritas utama)
- Responsif di desktop
- UX sederhana, cepat, dan mudah digunakan seperti aplikasi mobile

---

## Tech Stack
- Laravel (latest)
- PHP 8.x
- MySQL
- Tailwind CSS
- Blade / Laravel Breeze (direkomendasikan)
- Chart.js atau ApexCharts
- File Upload: local storage / S3 / Cloudinary

---

## Deployment & Environment
- Aplikasi harus dapat dijalankan menggunakan Docker
- Semua service berjalan via docker-compose
- Image aplikasi dibangun dari local
- Mendukung environment development

---

## User Roles
- Admin
- User

---

## Authentication
Gunakan:
- Laravel Breeze

### Login
- Email
- Password

### Register
- Name
- Email
- Password

### Rules
- Semua route menggunakan middleware auth
- User hanya bisa akses data miliknya
- Admin bisa akses semua data

---

## Core Features

### 1. Kas Masuk
Input:
- Nominal (required)
- Deskripsi (required)
- Foto struk (required)

Flow:
1. User submit data
2. Status = PENDING
3. Admin approval:
   - APPROVED → saldo bertambah
   - REJECTED → tidak mempengaruhi saldo

---

### 2. Kas Keluar
Input:
- Nominal (required)
- Deskripsi (required)
- Foto struk (required)

Validation:
- Nominal tidak boleh melebihi saldo

Flow:
1. User submit data
2. Status = PENDING
3. Admin approval:
   - APPROVED → saldo berkurang
   - REJECTED → tidak mempengaruhi saldo

---

### 3. Deposit (Iuran)
Input:
- Pilih bulan (default bulan berjalan)

Flow:
1. User pilih deposit
2. Tampilkan informasi rekening pembayaran
3. Submit permintaan deposit
4. Status = PENDING
5. Admin approval:
   - Wajib isi deskripsi
   - Optional upload foto bukti
6. Jika APPROVED → saldo bertambah

---

## Floating Action Button (FAB)

Flow:
1. Klik tombol "+"
2. Muncul bottom sheet
3. Pilihan:
   - Deposit
   - Kas Masuk
   - Kas Keluar

---

## Dashboard

### Data:
- Saldo utama
- Total kas masuk
- Total kas keluar

### Komponen:
- Summary cards
- List kategori (listrik, makanan, air, dll)

### Charts:
- Line Chart:
  - Kas masuk (deposit + kas masuk)
  - Kas keluar
  - Filter: 3 / 6 / 12 bulan

- Analisa:
  - Perbandingan bulan ini vs bulan lalu (persentase)

- Pie Chart:
  - Pengeluaran per kategori
  - Filter: tahunan

---

## Pages

### Dashboard
- Overview saldo dan statistik

### Kas Detail (Admin)
- List transaksi pending
- Approve / Reject
- Wajib isi deskripsi saat approval

### Riwayat Keuangan
Filter:
- Bulan
- Kategori
- User (admin)

### Deposit List
- Filter bulan

### Profile
- Update foto
- Update data
- List kas pribadi user

### Login
### Register

---

## Validations

- Semua input kas:
  - Nominal wajib
  - Deskripsi wajib
  - Foto wajib

- Warning:
  - Jika saldo < 200000 tampilkan alert

- Kas keluar:
  - Tidak boleh melebihi saldo

- Semua transaksi:
  - Harus melalui approval admin

- Approval:
  - Wajib isi deskripsi
  - Foto optional

---

## Database Design (Simplified)

### users
- id
- name
- email
- password
- role
- photo

### transactions
- id
- type (IN / OUT / DEPOSIT)
- amount
- description
- photo
- status (PENDING / APPROVED / REJECTED)
- user_id
- category_id
- created_at

### deposits
- id
- user_id
- month
- status
- description
- photo

### categories
- id
- name

---

## UX Guidelines

- Mobile-first (single column layout)
- Bottom navigation
- Card-based UI
- Bottom sheet untuk action
- Modal untuk konfirmasi
- Toast untuk feedback
- Loading state jelas

---

## Expected Output

- Clean code (modular, scalable)
- Struktur MVC Laravel rapi
- Reusable Blade components
- Validasi backend + frontend
- UI modern, ringan, dan cepat digunakan