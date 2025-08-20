<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= asset("css/style.css") ?>">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            color: #333;
        }

        .error-404 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .error-404 section {
            text-align: center;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 400px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease forwards;
        }

        .error-404 h1 {
            font-size: 5rem;
            color: #e74c3c;
            margin: 0;
            font-weight: 700;
            letter-spacing: 4px;
            animation: bounce 1.2s infinite;
        }

        .error-404 p {
            font-size: 1.25rem;
            margin: 0;
            color: #555;
        }

        .error-404 svg {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            fill: #fed700;
            transition: transform 0.3s ease;
        }

        .error-404 svg:hover {
            transform: scale(1.1) rotate(10deg);
        }

        .error-404 a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1.2rem;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .error-404 a:hover {
            background: #fed700;
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .error-404 h1 {
                font-size: 4rem;
            }

            .error-404 p {
                font-size: 1rem;
            }

            .error-404 svg {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>

<body>
    <?php Core\View::partial('partials.header'); ?>
    <main class="error-404" style="min-height: 80vh; display: flex; justify-content: center; align-items: center;">
        <section style="text-align:center; padding: 3rem 1rem; display: flex; flex-direction: column; gap: 1rem;">
            <h1 style="font-size: 3rem; color: #e74c3c;">404</h1>
            <p style="font-size: 1.5rem;">Trang bạn tìm kiếm không tồn tại.</p>
            <svg fill="#000000" height="102px" width="102px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" xml:space="preserve">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <g>
                        <path d="M9,39h6v8c0,0.552,0.448,1,1,1s1-0.448,1-1v-8h3c0.552,0,1-0.448,1-1s-0.448-1-1-1h-3v-2c0-0.552-0.448-1-1-1s-1,0.448-1,1 v2h-5V27c0-0.552-0.448-1-1-1s-1,0.448-1,1v11C8,38.552,8.448,39,9,39z"></path>
                        <path d="M40,39h6v8c0,0.552,0.448,1,1,1s1-0.448,1-1v-8h3c0.552,0,1-0.448,1-1s-0.448-1-1-1h-3v-2c0-0.552-0.448-1-1-1 s-1,0.448-1,1v2h-5V27c0-0.552-0.448-1-1-1s-1,0.448-1,1v11C39,38.552,39.448,39,40,39z"></path>
                        <path d="M29.5,48c3.584,0,6.5-2.916,6.5-6.5v-9c0-3.584-2.916-6.5-6.5-6.5S23,28.916,23,32.5v9C23,45.084,25.916,48,29.5,48z M25,32.5c0-2.481,2.019-4.5,4.5-4.5s4.5,2.019,4.5,4.5v9c0,2.481-2.019,4.5-4.5,4.5S25,43.981,25,41.5V32.5z"></path>
                        <path d="M0,0v14v46h60V14V0H0z M2,2h56v10H2V2z M58,58H2V14h56V58z"></path>
                        <polygon points="54.293,3.293 52,5.586 49.707,3.293 48.293,4.707 50.586,7 48.293,9.293 49.707,10.707 52,8.414 54.293,10.707 55.707,9.293 53.414,7 55.707,4.707 "></polygon>
                        <path d="M3,11h39V3H3V11z M5,5h35v4H5V5z"></path>
                    </g>
                </g>
            </svg>
            <a href="/" style="color: #3498db; text-decoration: underline;">Quay về trang chủ</a>
        </section>
    </main>

    <?php Core\View::partial('partials.footer'); ?>
</body>

</html>