# 🧠 LARAVEL BRAIN - SISTEM WORKSHOP

Dokumentasi pusat untuk arsitektur, logic, dan alur kerja Sistem Workshop.

---

## 📋 Project Overview
**Sistem Workshop** adalah platform manajemen pengerjaan (Job Order) dan inventaris material yang dirancang untuk menstandarisasi alur kerja antara Customer, Management, dan Tim Workshop.

### Core Value:
- **Transparansi:** Monitoring progress pengerjaan secara real-time.
- **Akuntabilitas:** Alur approval berjenjang (Management Customer -> Management EPP).
- **Efisiensi:** Manajemen stok material otomatis terpotong saat JO dibuat.

---

## 👥 User Roles & Permissions

| Role | Deskripsi | Key Permissions |
| :--- | :--- | :--- |
| **Admin** | Pengelola utama Workshop | CRUD JO, Master Data, Manajemen User, Update Progress. |
| **Customer** | Pemohon pengerjaan | Create JO, Monitoring JO miliknya, Resubmisi jika ditolak. |
| **Mgmt Customer** | Atasan Customer (per Dept) | Approval tahap 1, Filter notifikasi resubmisi. |
| **Mgmt EPP** | Otoritas Akhir | Approval tahap 2 (Final), Monitoring global. |

---

## 🛠️ Core Modules

### 1. Job Order Lifecycle
Alur hidup sebuah pengerjaan:
1. **Draft/Pending:** Dibuat oleh Customer/Admin. Stok material langsung "Booked" (Movement OUT).
2. **Requested:** Menunggu approval Management Customer.
3. **Approved Stage 1:** Disetujui Management Customer, lanjut ke EPP.
4. **Fully Approved:** Disetujui EPP. Data muncul di Dashboard & Monitoring.
5. **In Progress:** Dikerjakan oleh Workshop (Progress diupdate Admin).
6. **Completed:** Progress mencapai 100%.
7. **Rejected:** Ditolak Management. Stok dikembalikan otomatis (Movement IN).

### 2. Inventory System
Manajemen stok menggunakan model `Material` dan `MaterialMovement`.
- **Automatic Sync:** Setiap JO yang dibuat akan membuat record `MaterialMovement` tipe `out`.
- **Safety Stock:** Material yang stoknya di bawah `safety_stock` akan muncul di panel "Material Kritis".
- **History:** Semua perpindahan stok dicatat lengkap dengan referensi ID Job Order.

### 3. Notification Engine
Menggunakan `App\Services\NotificationService` untuk standarisasi pesan.
- **Triggers:** Create, Update, Delete, Approve, Reject, Resubmitted, Admin Edit/Delete.
- **Department Isolation:** Notifikasi hanya dikirim ke user yang berada di departemen yang sama (kecuali Admin & EPP).

### 4. Dashboard & Monitoring
- **Admin/EPP:** Melihat data agregat seluruh departemen.
- **Customer/MJC:** Hanya melihat data departemen mereka sendiri.
- **Monitoring Page:** Publik (Guest accessible), hanya menampilkan JO yang sudah `Fully Approved`.

---

## 📂 Key File Structure

- **Controllers:**
  - `Admin/`: Manajemen operasional workshop.
  - `Customer/`: Form input dan monitoring user.
  - `ManagementCustomer/`: Verifikasi internal departemen.
  - `ManagementEpp/`: Otoritas final perusahaan.
- **Services:**
  - `NotificationService.php`: Pusat logic pengiriman notifikasi.
- **Models:**
  - `JobOrder.php`: Logic approval scope dan relasi.
  - `Material.php`: Logic perhitungan stok terkini.
- **Views:**
  - `monitor.blade.php`: Tampilan live monitoring (TV Display).

---

## 📝 Recent Major Updates (Memory)
- **Monitoring Sync:** Perbaikan query agar monitoring hanya menampilkan data yang sudah disetujui EPP.
- **Department Filter:** Penambahan filter departemen di Monitoring dan Dashboard Admin.
- **Admin Notifications:** Penambahan trigger notifikasi ke Customer saat Admin melakukan Edit/Delete JO.
- **Security Fix:** Penutupan filter resubmisi untuk role selain Management Customer.

---
*Dokumentasi ini adalah "Otak" dari project ini. Update file ini setiap kali ada perubahan arsitektur besar.*
