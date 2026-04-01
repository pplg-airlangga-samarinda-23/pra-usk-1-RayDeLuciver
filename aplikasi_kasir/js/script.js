// Fungsi format rupiah
function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(num);
}

// ===== HALAMAN LOGIN =====
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    
    document.getElementById(tab + '-content').classList.add('active');
    event.target.classList.add('active');
}

function handleLogin(e) {
    e.preventDefault();
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;
    
    fetch('api/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            localStorage.setItem('user', JSON.stringify(data.user));
            window.location.href = 'dashboard.php';
        } else {
            showAlert('login-alert', data.message, 'danger');
        }
    })
    .catch(err => console.error(err));
}

function handleRegister(e) {
    e.preventDefault();
    const nama = document.getElementById('register-nama').value;
    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;
    
    fetch('api/registrasi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nama, username, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showAlert('register-alert', data.message, 'success');
            document.getElementById('register-form').reset();
            setTimeout(() => {
                document.querySelector('[data-tab="login"]').click();
            }, 1500);
        } else {
            showAlert('register-alert', data.message, 'danger');
        }
    })
    .catch(err => console.error(err));
}

function showAlert(id, message, type) {
    const alertDiv = document.getElementById(id);
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    alertDiv.style.display = 'block';
    
    if (type === 'success') {
        setTimeout(() => {
            alertDiv.style.display = 'none';
        }, 3000);
    }
}

// ===== HALAMAN KASIR =====
let cart = [];
let produkList = [];

function loadProduk() {
    fetch('api/produk.php')
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            produkList = data.data;
            displayProduk();
        }
    })
    .catch(err => console.error(err));
}

function displayProduk() {
    const container = document.getElementById('produk-container');
    container.innerHTML = '';
    
    produkList.forEach(produk => {
        const div = document.createElement('div');
        div.className = 'produk-item';
        div.innerHTML = `
            <h4>${produk.NamaProduk}</h4>
            <div class="harga">${formatRupiah(produk.Harga)}</div>
            <div class="stok">Stok: ${produk.Stok}</div>
            <button class="btn-tambah" onclick="addToCart(${produk.ProdukID}, '${produk.NamaProduk}', ${produk.Harga})" 
                    ${produk.Stok === 0 ? 'disabled' : ''}>+ Tambah</button>
        `;
        container.appendChild(div);
    });
}

function addToCart(id, nama, harga) {
    const existingItem = cart.find(item => item.produk_id === id);
    
    if (existingItem) {
        existingItem.jumlah++;
    } else {
        cart.push({
            produk_id: id,
            nama: nama,
            harga: harga,
            jumlah: 1
        });
    }
    
    updateCart();
}

function updateCart() {
    const cartContainer = document.getElementById('cart-items');
    cartContainer.innerHTML = '';
    
    let total = 0;
    
    cart.forEach((item, index) => {
        const subtotal = item.harga * item.jumlah;
        total += subtotal;
        
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-name">${item.nama}</div>
            <div class="cart-item-qty">
                <input type="number" min="1" value="${item.jumlah}" 
                       onchange="updateCartQty(${index}, this.value)">
            </div>
            <div class="cart-item-price">${formatRupiah(subtotal)}</div>
            <button class="cart-item-delete" onclick="removeFromCart(${index})">×</button>
        `;
        cartContainer.appendChild(div);
    });
    
    document.getElementById('cart-total').textContent = formatRupiah(total);
    document.getElementById('cart-total-value').value = total;
}

function updateCartQty(index, qty) {
    cart[index].jumlah = parseInt(qty);
    if (cart[index].jumlah <= 0) {
        removeFromCart(index);
    } else {
        updateCart();
    }
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function clearCart() {
    cart = [];
    updateCart();
}

function checkout() {
    if (cart.length === 0) {
        alert('Keranjang kosong!');
        return;
    }
    
    const total = document.getElementById('cart-total-value').value;
    
    fetch('api/penjualan.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            items: cart,
            total: total
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Penjualan berhasil disimpan!\nTanggal: ' + new Date().toLocaleString('id-ID'));
            clearCart();
            loadProduk();
        } else {
            alert('Gagal menyimpan penjualan: ' + data.message);
        }
    })
    .catch(err => console.error(err));
}

// ===== HALAMAN PRODUK (ADMIN) =====
function loadProdukAdmin() {
    fetch('api/produk.php')
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            displayProdukAdmin(data.data);
        }
    })
    .catch(err => console.error(err));
}

function displayProdukAdmin(produk) {
    const tbody = document.getElementById('produk-table-body');
    tbody.innerHTML = '';
    
    produk.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.ProdukID}</td>
            <td>${item.NamaProduk}</td>
            <td>${formatRupiah(item.Harga)}</td>
            <td>${item.Stok}</td>
            <td>
                <button class="btn-edit" onclick="editProduk(${item.ProdukID})">Edit</button>
                <button class="btn-delete" onclick="deleteProduk(${item.ProdukID})">Hapus</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function openAddProdukModal() {
    document.getElementById('form-produk').reset();
    document.getElementById('produk-id').value = '';
    document.getElementById('produk-modal-title').textContent = 'Tambah Produk';
    document.getElementById('produk-modal').classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

function saveProduk(e) {
    e.preventDefault();
    
    const id = document.getElementById('produk-id').value;
    const nama = document.getElementById('produk-nama').value;
    const harga = document.getElementById('produk-harga').value;
    const stok = document.getElementById('produk-stok').value;
    
    const method = id ? 'PUT' : 'POST';
    const body = {
        nama_produk: nama,
        harga: harga,
        stok: stok
    };
    
    if (id) {
        body.id = id;
    }
    
    fetch('api/produk.php', {
        method: method,
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            closeModal('produk-modal');
            loadProdukAdmin();
        } else {
            alert('Gagal: ' + data.message);
        }
    })
    .catch(err => console.error(err));
}

function editProduk(id) {
    const produk = produkList.find(p => p.ProdukID == id);
    if (produk) {
        document.getElementById('produk-id').value = produk.ProdukID;
        document.getElementById('produk-nama').value = produk.NamaProduk;
        document.getElementById('produk-harga').value = produk.Harga;
        document.getElementById('produk-stok').value = produk.Stok;
        document.getElementById('produk-modal-title').textContent = 'Edit Produk';
        document.getElementById('produk-modal').classList.add('active');
    }
}

function deleteProduk(id) {
    if (confirm('Yakin ingin menghapus produk ini?')) {
        fetch('api/produk.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                loadProdukAdmin();
            } else {
                alert('Gagal: ' + data.message);
            }
        })
        .catch(err => console.error(err));
    }
}

// ===== HALAMAN LAPORAN =====
function loadLaporan() {
    fetch('api/penjualan.php')
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            displayLaporan(data.data);
        }
    })
    .catch(err => console.error(err));
}

function displayLaporan(penjualan) {
    const tbody = document.getElementById('laporan-table-body');
    tbody.innerHTML = '';

    penjualan.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.PenjualanID}</td>
            <td>${item.NamaPengguna}</td>
            <td>${item.TanggalPenjualan}</td>
            <td>${formatRupiah(item.TotalHarga)}</td>
            <td>
                <button class="btn btn-delete" onclick="deletePenjualan(${item.PenjualanID})">Hapus</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function deletePenjualan(penjualanId) {
    if (!confirm('Yakin ingin menghapus penjualan ini?')) {
        return;
    }

    fetch('api/penjualan.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ penjualan_id: penjualanId })
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('HTTP ' + res.status + ' - ' + res.statusText);
        }
        return res.json();
    })
    .then(data => {
        console.log('DELETE response', data);

        if (data.status === 'success') {
            alert('Berhasil: ' + data.message);
            loadLaporan();
        } else {
            alert('Gagal menghapus: ' + data.message);
        }
    })
    .catch(err => {
        console.error('DELETE error', err);
        alert('Terjadi kesalahan saat menghapus data. Buka DevTools untuk detail.');
    });
}

function logout() {
    fetch('api/logout.php')
    .then(res => res.json())
    .then(data => {
        localStorage.removeItem('user');
        window.location.href = 'index.php';
    })
    .catch(err => console.error(err));
}
