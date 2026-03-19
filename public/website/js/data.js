/**
 * Mock Data for E-Commerce Site
 * In a real application, this would come from an API
 */

const Products = [
    {
        id: 1,
        name: 'Wireless Bluetooth Headphones',
        category: 'Electronics',
        price: 79.99,
        oldPrice: 99.99,
        image: 'https://via.placeholder.com/400x400?text=Headphones',
        rating: 4.5,
        reviews: 128,
        badge: 'Best Seller',
        description: 'High-quality wireless headphones with noise cancellation and 30-hour battery life.',
        colors: ['Black', 'White', 'Blue'],
        sizes: null,
        inStock: true
    },
    {
        id: 2,
        name: 'Smart Watch Pro',
        category: 'Electronics',
        price: 249.99,
        image: 'https://via.placeholder.com/400x400?text=Smart+Watch',
        rating: 4.8,
        reviews: 256,
        badge: 'New',
        description: 'Feature-rich smartwatch with health tracking, GPS, and water resistance.',
        colors: ['Black', 'Silver', 'Rose Gold'],
        sizes: null,
        inStock: true
    },
    {
        id: 3,
        name: 'Classic Denim Jacket',
        category: 'Fashion',
        price: 59.99,
        oldPrice: 79.99,
        image: 'https://via.placeholder.com/400x400?text=Denim+Jacket',
        rating: 4.3,
        reviews: 89,
        description: 'Timeless denim jacket perfect for any season. Made from premium cotton denim.',
        colors: ['Blue', 'Black'],
        sizes: ['S', 'M', 'L', 'XL'],
        inStock: true
    },
    {
        id: 4,
        name: 'Running Shoes',
        category: 'Sports',
        price: 89.99,
        image: 'https://via.placeholder.com/400x400?text=Running+Shoes',
        rating: 4.6,
        reviews: 342,
        badge: 'Best Seller',
        description: 'Comfortable running shoes with advanced cushioning and breathable mesh.',
        colors: ['Black', 'White', 'Red'],
        sizes: ['7', '8', '9', '10', '11', '12'],
        inStock: true
    },
    {
        id: 5,
        name: 'Leather Backpack',
        category: 'Accessories',
        price: 129.99,
        oldPrice: 159.99,
        image: 'https://via.placeholder.com/400x400?text=Backpack',
        rating: 4.7,
        reviews: 156,
        description: 'Premium leather backpack with multiple compartments and laptop sleeve.',
        colors: ['Brown', 'Black'],
        sizes: null,
        inStock: true
    },
    {
        id: 6,
        name: 'Cotton T-Shirt',
        category: 'Fashion',
        price: 19.99,
        image: 'https://via.placeholder.com/400x400?text=T-Shirt',
        rating: 4.2,
        reviews: 234,
        description: 'Soft cotton t-shirt available in multiple colors. Perfect for everyday wear.',
        colors: ['White', 'Black', 'Gray', 'Navy', 'Red'],
        sizes: ['S', 'M', 'L', 'XL', 'XXL'],
        inStock: true
    },
    {
        id: 7,
        name: 'Wireless Mouse',
        category: 'Electronics',
        price: 29.99,
        image: 'https://via.placeholder.com/400x400?text=Mouse',
        rating: 4.4,
        reviews: 187,
        description: 'Ergonomic wireless mouse with precision tracking and long battery life.',
        colors: ['Black', 'White'],
        sizes: null,
        inStock: true
    },
    {
        id: 8,
        name: 'Sunglasses',
        category: 'Accessories',
        price: 49.99,
        oldPrice: 69.99,
        image: 'https://via.placeholder.com/400x400?text=Sunglasses',
        rating: 4.5,
        reviews: 98,
        description: 'Stylish sunglasses with UV protection and polarized lenses.',
        colors: ['Black', 'Brown', 'Blue'],
        sizes: null,
        inStock: true
    }
];

const Categories = [
    'All',
    'Electronics',
    'Fashion',
    'Sports',
    'Accessories'
];

const Reviews = {
    1: [
        {
            author: 'John Doe',
            date: '2024-01-15',
            rating: 5,
            content: 'Excellent headphones! Great sound quality and comfortable to wear for long periods.'
        },
        {
            author: 'Jane Smith',
            date: '2024-01-10',
            rating: 4,
            content: 'Good value for money. Battery life is impressive.'
        }
    ],
    2: [
        {
            author: 'Mike Johnson',
            date: '2024-01-20',
            rating: 5,
            content: 'Love this smartwatch! The health tracking features are very accurate.'
        }
    ]
};

// Helper function to get product by ID
function getProductById(id) {
    return Products.find(p => p.id === parseInt(id));
}

// Helper function to get products by category
function getProductsByCategory(category) {
    if (category === 'All' || !category) return Products;
    return Products.filter(p => p.category === category);
}

// Helper function to filter products
function filterProducts(filters) {
    let filtered = Products;
    
    if (filters.category && filters.category !== 'All') {
        filtered = filtered.filter(p => p.category === filters.category);
    }
    
    if (filters.minPrice) {
        filtered = filtered.filter(p => p.price >= filters.minPrice);
    }
    
    if (filters.maxPrice) {
        filtered = filtered.filter(p => p.price <= filters.maxPrice);
    }
    
    if (filters.rating) {
        filtered = filtered.filter(p => p.rating >= filters.rating);
    }
    
    return filtered;
}

// Make filterProducts available globally
window.filterProducts = filterProducts;

// Helper function to sort products
function sortProducts(products, sortBy) {
    const sorted = [...products];
    
    switch(sortBy) {
        case 'price-low':
            return sorted.sort((a, b) => a.price - b.price);
        case 'price-high':
            return sorted.sort((a, b) => b.price - a.price);
        case 'rating':
            return sorted.sort((a, b) => b.rating - a.rating);
        case 'name':
            return sorted.sort((a, b) => a.name.localeCompare(b.name));
        default:
            return sorted;
    }
}

// Make sortProducts available globally
window.sortProducts = sortProducts;
