<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cafe Manager — Sign In</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --orange: #d4611a;
            --orange-dark: #b84f12;
            --orange-light: #f8ede3;
            --card-bg: #faf8f5;
            --text-dark: #1e1e2e;
            --text-muted: #7a7a8c;
            --border: #e8e0d5;
            --input-bg: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "DM Sans", sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: #3d2c1e;
        }

        /* ── Background photo + overlay ── */
        .bg-photo {
            position: fixed;
            inset: 0;
            background:
                linear-gradient(160deg,
                    rgba(40, 24, 10, 0.65) 0%,
                    rgba(100, 65, 30, 0.45) 100%),
                /* url("https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1600&q=80")
            center/cover no-repeat; */
                url("https://images.unsplash.com/photo-1509042239860-f550ce710b93") center/cover no-repeat;
            z-index: 0;
        }

        /* ── Card ── */
        .login-card {
            position: relative;
            z-index: 10;
            background: var(--card-bg);
            border-radius: 20px;
            padding: 44px 44px 36px;
            padding: 2%;
            width: 100%;
            max-width: 32%;
            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.35),
                0 2px 0 rgba(255, 255, 255, 0.05) inset;
            animation: slideUp 0.55s cubic-bezier(0.22, 0.68, 0, 1.2) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(32px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── Logo circle ── */
        .logo-wrap {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--orange-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
        }

        .logo-wrap svg {
            width: 30px;
            height: 30px;
            color: var(--orange);
        }

        /* ── Headings ── */
        h1 {
            font-family: "Playfair Display", serif;
            font-size: 2rem;
            color: var(--text-dark);
            text-align: center;
            margin-bottom: 6px;
        }

        .subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.92rem;
            margin-bottom: 30px;
        }

        /* ── Labels ── */
        label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
            display: block;
        }

        /* ── Input group ── */
        .input-group {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            /* overflow: hidden; */
            background: var(--input-bg);
            transition:
                border-color 0.2s,
                box-shadow 0.2s;
        }

        .input-group:focus-within {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(212, 97, 26, 0.12);

        }

        .input-group-text {
            background: transparent;
            border: none;
            padding: 0 14px;
            color: #b0a898;
        }

        input {
            border: none;
        }

        .form-control {
            border: none;
            background: transparent;
            font-size: 0.93rem;
            color: var(--text-dark);
            padding: 13px 4px;
            box-shadow: none !important;
        }

        .form-control::placeholder {
            color: #c5bdb3;
        }

        /* ── Password row ── */
        .pw-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .forgot-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--orange);
            text-decoration: none;
            transition: color 0.15s;
        }

        

        .toggle-pw {
            background: transparent;
            border: none;
            padding: 0 14px;

            margin-left: 90px;
            color: #b0a898;
            cursor: pointer;
            transition: color 0.15s;
        }

        .toggle-pw:hover {
            color: var(--orange);
        }

        /* ── Checkbox ── */
        .form-check-label {
            font-size: 0.88rem;
            color: var(--text-muted);
            cursor: pointer;
        }

        .form-check-input {
            border-color: #cec5bc;
            width: 17px;
            height: 17px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--orange);
            border-color: var(--orange);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(212, 97, 26, 0.15);
        }





        /* ── Divider ── */
        .divider {
            border-top: 1.5px solid var(--border);
            margin: 28px 0 20px;
        }

        /* ── Back link ── */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: var(--text-muted);
            font-size: 0.88rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s;
        }

        .back-link:hover {
            color: var(--text-dark);
        }

        .back-link svg {
            width: 15px;
            height: 15px;
        }

        /* ── Footer links ──
        .footer-links {
            position: relative;
            z-index: 10;
            margin-top: 22px;
            display: flex;
            gap: 24px;
            justify-content: center;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.8rem;
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-links a:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        /* ── Spacing helpers ── */
        .mb-field {
            margin-bottom: 18px;
        }

        input {
            outline: none;
        }

        .SignInbtn {
            width: 100%;

            background: rgb(231, 92, 6);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(162, 64, 3, 0.35);
            border: none;
            border-radius: 5px;
            font-size: 17px;
            padding: 10px;
            color: #fff;
            font-weight: 900;
        }

        .SignInbtn svg {
            width: 18px;
            height: 18px;
            color: #fffefe;
            font-weight: 900;
            padding-top: 5px;
            font-size: 17px;
        }

        .SignInbtn:hover {
            background: rgb(237, 173, 43);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(245, 149, 5, 0.35);
        }

        input:-webkit-autofill {
            /* Delay the background color change indefinitely */
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #050505 !important;
           
        }

        @media only screen and (max-width: 991px) {
            .login-card {
                max-width: 90%;
            }

            .toggle-pw {
                margin-left: 80px;
            }
        }
    </style>
</head>

<body>

    <div class="bg-photo"></div>

    <div class="login-card">
        <form method="POST" action="admin_login.php">
            <!-- Logo -->
            <div class="logo-wrap">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1" />
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                    <line x1="6" y1="1" x2="6" y2="4" />
                    <line x1="10" y1="1" x2="10" y2="4" />
                    <line x1="14" y1="1" x2="14" y2="4" />
                </svg>
            </div>

            <h1>Welcome Back</h1>
            <p class="subtitle">Sign in to manage your cafe</p>

            <!-- Username -->
            <div class="mb-field">
                <label for="email">Username or Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <input
                        type="email"
                        id="email"
                        class="form-control"
                        name="email"
                        placeholder="manager@cafe.com"
                        required />
                </div>
            </div>

            <!-- Password -->
            <div class="mb-field">
                <div class="pw-label-row mb-1">
                    <label for="password" class="mb-0">Password</label>
                    <!-- <a href="#" class="forgot-link">Forgot password?</a> -->
                </div>
                <div class="input-group">
                    <span class="input-group-text">
                        <svg
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </span>
                    <input
                        type="password"
                        id="password"
                        class="form-control"

                        name="password"
                        placeholder="Password"
                        required
                        autocomplete="current-password" />
                    <button
                        class="toggle-pw"
                        id="togglePw"
                        type="button"
                        aria-label="Toggle password visibility">
                        <!-- eye icon -->
                        <svg
                            id="eyeIcon"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>



            <!-- Sign In -->

            <button class="SignInbtn mt-3" name="btn">Sign In
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.5"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    <polyline points="10 17 15 12 10 7" />
                    <line x1="15" y1="12" x2="3" y2="12" />
                </svg>
            </button>
            <!-- <button type="submit" name="btn">sign in</button> -->
            <div class="divider"></div>

            <!-- Back -->
            <a href="../index.php" class="back-link">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Back to Main Website
            </a>
        </form>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePw').addEventListener("click", () => {
            let password = document.getElementById('password');
            // Assign the result of the ternary back to the element's type
            password.type = password.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>

</html>