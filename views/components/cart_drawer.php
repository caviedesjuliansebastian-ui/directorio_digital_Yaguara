<!-- ============================================================
     CARRITO DE COMPRAS & PEDIDOS (DRAWER OFFCANVAS)
     ============================================================ -->
<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="cartDrawer" style="background: var(--bg-card) !important; border-left: 1px solid var(--border-color); width: 380px;">
    <div class="offcanvas-header border-bottom" style="border-color: var(--border-color) !important;">
        <h5 class="offcanvas-title text-white fw-bold d-flex align-items-center gap-2">
            <i class="fas fa-shopping-cart text-warning"></i> Mi Carrito de Pedido
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    
    <div class="offcanvas-body d-flex flex-column justify-content-between p-4">
        
        <!-- Cart Items List -->
        <div id="cart-items-container" class="d-flex flex-column gap-3 overflow-y-auto" style="max-height: 340px;">
            <div class="text-center py-5 text-secondary" id="empty-cart-msg">
                <i class="fas fa-shopping-bag fa-3x mb-3 text-secondary opacity-50"></i>
                <h6 class="text-white">Tu carrito está vacío</h6>
                <small>Agrega productos o platos típicos desde la vitrina o menú de cualquier comercio.</small>
            </div>
        </div>

        <!-- Order Options & Summary -->
        <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
            
            <!-- Delivery Type -->
            <label class="form-label text-secondary small fw-bold mb-2">Modalidad de Entrega:</label>
            <div class="btn-group w-100 mb-3" role="group">
                <input type="radio" class="btn-check" name="delivery_type" id="del_domicilio" value="Domicilio" checked onchange="updateCartDelivery()">
                <label class="btn btn-outline-warning btn-sm" for="del_domicilio"><i class="fas fa-motorcycle me-1"></i> Domicilio</label>

                <input type="radio" class="btn-check" name="delivery_type" id="del_recoger" value="Recoger en Tienda" onchange="updateCartDelivery()">
                <label class="btn btn-outline-warning btn-sm" for="del_recoger"><i class="fas fa-store me-1"></i> Recoger</label>
            </div>

            <div class="mb-3">
                <input type="text" id="cart-address" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Dirección en Yaguará (ej. Cra 4 # 5-20 Centro)...">
            </div>

            <!-- Total Price -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary fw-semibold">Total a Pagar:</span>
                <span class="h4 fw-bold text-white mb-0" id="cart-total-price">$0 COP</span>
            </div>

            <!-- Send to Chat Action -->
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <button type="button" class="btn btn-warning w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-2" onclick="sendCartOrderToChat()" style="background: var(--color-primary); color: white; border: none; border-radius: 12px;">
                    <i class="fas fa-paper-plane"></i> Enviar Pedido al Chat
                </button>
            <?php else: ?>
                <a href="<?= BASE_URL ?>index.php?url=autenticacion/login" class="btn btn-warning w-100 fw-bold py-2 d-flex align-items-center justify-content-center gap-2" style="background: var(--color-primary); color: white; border: none; border-radius: 12px;">
                    <i class="fas fa-lock"></i> Iniciar Sesión para Pedir
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Floating Cart Trigger Button -->
<button type="button" class="floating-cart-btn" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer" style="position: fixed; bottom: 1.5rem; right: 1.5rem; width: 56px; height: 56px; border-radius: 50%; background: var(--color-primary); color: white; border: none; box-shadow: 0 4px 15px rgba(255, 92, 0, 0.4); display: flex; align-items: center; justify-content: center; z-index: 1050; font-size: 1.25rem;">
    <i class="fas fa-shopping-bag"></i>
    <span class="cart-floating-badge" id="floating-cart-count" style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; font-size: 0.7rem; font-weight: 700; width: 22px; height: 22px; border-radius: 50%; display: none; align-items: center; justify-content: center; border: 2px solid #111315;">0</span>
</button>

<script>
// Carrito State Manager
let cart = JSON.parse(localStorage.getItem('servigo_cart') || '[]');

function addToCart(id, name, price, businessId, businessName, qty = 1) {
    const quantity = parseInt(qty) || 1;
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.qty += quantity;
    } else {
        cart.push({ id, name, price: parseFloat(price), businessId, businessName, qty: quantity });
    }
    saveCart();
    renderCart();
    
    // Abrir drawer automáticamente
    const drawerEl = document.getElementById('cartDrawer');
    if (drawerEl) {
        const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(drawerEl);
        bsOffcanvas.show();
    }
}

function updateCartQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.qty += delta;
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
    }
    saveCart();
    renderCart();
}

function saveCart() {
    localStorage.setItem('servigo_cart', JSON.stringify(cart));
}

function renderCart() {
    const container = document.getElementById('cart-items-container');
    const totalEl = document.getElementById('cart-total-price');
    const badgeEl = document.getElementById('floating-cart-count');
    
    if (!container) return;

    if (cart.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 text-secondary">
                <i class="fas fa-shopping-bag fa-3x mb-3 text-secondary opacity-50"></i>
                <h6 class="text-white">Tu carrito está vacío</h6>
                <small>Agrega productos o platos típicos desde la vitrina o menú de cualquier comercio.</small>
            </div>
        `;
        if (totalEl) totalEl.textContent = '$0 COP';
        if (badgeEl) badgeEl.style.display = 'none';
        return;
    }

    let total = 0;
    let totalItems = 0;
    let html = '';

    cart.forEach(item => {
        const sub = item.price * item.qty;
        total += sub;
        totalItems += item.qty;
        html += `
            <div class="p-2 rounded-3 d-flex justify-content-between align-items-center" style="background: var(--bg-card-light); border: 1px solid var(--border-color);">
                <div style="max-width: 170px;">
                    <div class="text-white fw-bold text-truncate" style="font-size: 0.85rem;">${item.name}</div>
                    <small class="text-warning">$${item.price.toLocaleString('es-CO')} COP</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-dark px-2 py-0 border-secondary" onclick="updateCartQty(${item.id}, -1)">-</button>
                    <span class="text-white fw-bold small">${item.qty}</span>
                    <button class="btn btn-sm btn-dark px-2 py-0 border-secondary" onclick="updateCartQty(${item.id}, 1)">+</button>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    if (totalEl) totalEl.textContent = '$' + total.toLocaleString('es-CO') + ' COP';
    if (badgeEl) {
        badgeEl.textContent = totalItems;
        badgeEl.style.display = 'flex';
    }
}

function sendCartOrderToChat() {
    if (cart.length === 0) {
        alert('Agrega al menos un producto a tu carrito.');
        return;
    }

    const businessId = cart[0].businessId || 1;
    const delivery = document.querySelector('input[name="delivery_type"]:checked')?.value || 'Domicilio';
    const address = document.getElementById('cart-address')?.value || 'Zona Urbana Yaguará';

    let orderText = `🛒 *NUEVO PEDIDO FORMAL - SERVI-GO*\nModalidad: ${delivery}\nDirección/Nota: ${address}\n\n*Detalle de Productos:*\n`;
    let total = 0;

    cart.forEach(item => {
        const sub = item.price * item.qty;
        total += sub;
        orderText += `• ${item.qty}x ${item.name} ($${sub.toLocaleString('es-CO')} COP)\n`;
    });

    orderText += `\n*TOTAL A PAGAR: $${total.toLocaleString('es-CO')} COP*`;

    // Redirigir al chat con el pedido
    window.location.href = `<?= BASE_URL ?>index.php?url=chat/conversacion/${businessId}`;
}

document.addEventListener('DOMContentLoaded', renderCart);
</script>
