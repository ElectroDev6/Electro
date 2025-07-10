<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - <?php echo htmlspecialchars($product['name'] ?? 'Unknown Product'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .product-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
        }

        .product-details {
            margin-top: 20px;
        }

        .product-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .product-details p {
            margin: 5px 0;
        }

        .promotion,
        .offer,
        .gift {
            color: green;
            font-weight: bold;
        }

        .review {
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="product-container">
        <?php if (isset($product['image_url']) && !empty($product['image_url'])): ?>
            <div class="product-image">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name'] ?? 'Product Image'); ?>">
            </div>
        <?php endif; ?>

        <div class="product-details">
            <h1><?php echo htmlspecialchars($product['name'] ?? 'No Name'); ?></h1>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'] ?? 0, 2); ?></p>
            <p><strong>Stock:</strong> <?php echo $product['stock_quantity'] ?? 0; ?> units</p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></p>
            <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name'] ?? 'N/A'); ?></p>
            <p><strong>Created At:</strong> <?php echo date('F j, Y H:i', strtotime($product['created_at'] ?? 'now')); ?></p>

            <?php if (isset($product['description']) && !empty($product['description'])): ?>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <?php endif; ?>

            <?php if (isset($product['promotion_details']) && !empty($product['promotion_details'])): ?>
                <p class="promotion"><strong>Promotion:</strong> <?php echo htmlspecialchars($product['promotion_details']); ?></p>
            <?php endif; ?>

            <?php if (isset($product['offer_details']) && !empty($product['offer_details'])): ?>
                <p class="offer"><strong>Payment Offer:</strong> <?php echo htmlspecialchars($product['offer_details']); ?></p>
            <?php endif; ?>

            <?php if (isset($product['gift_details']) && !empty($product['gift_details'])): ?>
                <p class="gift"><strong>Gift:</strong> <?php echo htmlspecialchars($product['gift_details']); ?></p>
            <?php endif; ?>

            <?php if (isset($product['variant_details']) && !empty($product['variant_details'])): ?>
                <p><strong>Variants:</strong> <?php echo htmlspecialchars($product['variant_details']); ?></p>
            <?php endif; ?>

            <?php if (isset($product['rating']) && !empty($product['rating'])): ?>
                <div class="review">
                    <p><strong>Rating:</strong> <?php echo $product['rating']; ?>/5</p>
                    <?php if (isset($product['comment']) && !empty($product['comment'])): ?>
                        <p><strong>Review:</strong> <?php echo htmlspecialchars($product['comment']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>