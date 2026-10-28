<div class="qty-box">
    <button type="button" class="js-qty-minus" aria-label="Giảm">−</button>
    <input type="number" class="js-qty-input" value="{{ $qty }}" min="1" max="{{ config('aura.max_qty', 99) }}" aria-label="Số lượng">
    <button type="button" class="js-qty-plus" aria-label="Tăng">+</button>
</div>
