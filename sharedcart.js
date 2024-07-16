let cart = [];
let isCartVisible = false; // Variable to track the visibility of the cart items

const toggleCart = () => {
    const cartElement = document.getElementById('cart');
    cartElement.classList.toggle('showCart');
    isCartVisible = !isCartVisible;
    updateCartList(); // Update the cart list visibility
}

const updateCartCount = () => {
    const cartCountElement = document.getElementById('cartCount');
    const totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
    cartCountElement.innerText = totalQuantity;
}

const addToCart = (productName, productPrice) => {
    const genderInputs = document.getElementsByName('Gender');
    let selectedGender;
    for (const input of genderInputs) {
        if (input.checked) {
            selectedGender = input.value;
            break;
        }
    }

    const selectedType = document.getElementById('age').value;

    if (!selectedGender || !selectedType) {
        alert('Please select gender and type before adding to cart');
        return;
    }

    const existingItemIndex = cart.findIndex(item => item.name === productName && item.gender === selectedGender && item.type === selectedType);

    if (existingItemIndex !== -1) {
        cart[existingItemIndex].quantity++;
    } else {
        cart.push({
            name: productName,
            price: productPrice,
            quantity: 1,
            gender: selectedGender,
            type: selectedType
        });
    }
    localStorage.setItem('cart', JSON.stringify(cart));

    updateCartCount();
    updateCartList();
}

const updateCartList = () => {
    const cartListElement = document.getElementById('cartList');
    cartListElement.innerHTML = '';

    let totalCartPrice = 0; // Variable to store the total price of all items in the cart

    if (isCartVisible) { // Only show detailed cart items if the cart is visible
        cart.forEach(item => {
            const newItem = document.createElement('div');
            newItem.classList.add('item');
            newItem.innerHTML = `
                <div class="name">${item.name}</div>
                <div class="gender">Gender: ${item.gender}</div>
                <div class="type">Type: ${item.type}</div>
                <div class="rate">Rate: ${item.price}</div>
                <div class="totalPrice">Total: $${item.price * item.quantity}</div>
                <div class="quantity">
                    <span class="minus" onclick="changeQuantityCart('${item.name}', 'minus')">-</span>
                    <span>${item.quantity}</span>
                    <span class="plus" onclick="changeQuantityCart('${item.name}', 'plus')">+</span>
                </div>
            `;
            cartListElement.appendChild(newItem);

            // Add the total price of each item to the totalCartPrice
            totalCartPrice += item.price * item.quantity;
        });
    }

    // Display the total cart price
    const totalCartPriceElement = document.getElementById('totalCartPrice');
    totalCartPriceElement.innerText = `Total: $${totalCartPrice}`;
}

const changeQuantityCart = (productName, type) => {
    const itemIndex = cart.findIndex(item => item.name === productName);

    if (itemIndex >= 0) {
        switch (type) {
            case 'plus':
                cart[itemIndex].quantity++;
                break;
            case 'minus':
                cart[itemIndex].quantity = Math.max(1, cart[itemIndex].quantity - 1);
                if (cart[itemIndex].quantity === 1) {
                    // Optionally, remove the item from the cart when quantity becomes 0
                    // cart.splice(itemIndex, 1);
                }
                break;
            default:
                break;
        }
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartList();
}
