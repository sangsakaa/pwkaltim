<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>403 - Akses Ditolak</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      background:
        radial-gradient(circle at top left, rgba(91, 33, 182, .25), transparent 30%),
        radial-gradient(circle at bottom right, rgba(59, 130, 246, .25), transparent 30%),
        linear-gradient(135deg, #0f172a, #1e293b);
      position: relative;
    }

    /* Background Blur Bubble */
    .bubble {
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      opacity: .3;
      animation: float 10s infinite ease-in-out;
    }

    .bubble.one {
      width: 300px;
      height: 300px;
      background: #6366f1;
      top: -100px;
      left: -100px;
    }

    .bubble.two {
      width: 250px;
      height: 250px;
      background: #3b82f6;
      bottom: -80px;
      right: -80px;
      animation-delay: 3s;
    }

    @keyframes float {

      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-30px);
      }
    }

    .card {
      width: 90%;
      max-width: 520px;
      padding: 50px;
      text-align: center;
      border-radius: 32px;
      background: rgba(255, 255, 255, .08);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, .12);
      box-shadow:
        0 20px 60px rgba(0, 0, 0, .35),
        inset 0 1px 1px rgba(255, 255, 255, .15);
      color: white;
      position: relative;
      z-index: 10;
    }

    .emoji {
      font-size: 90px;
      margin-bottom: 20px;
      animation: shake 4s infinite ease-in-out;
    }

    @keyframes shake {

      0%,
      100% {
        transform: rotate(0deg);
      }

      25% {
        transform: rotate(-6deg);
      }

      50% {
        transform: rotate(6deg);
      }

      75% {
        transform: rotate(-3deg);
      }
    }

    .code {
      font-size: 90px;
      font-weight: 900;
      background: linear-gradient(to right, #60a5fa, #a78bfa);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      line-height: 1;
    }

    h2 {
      margin-top: 15px;
      font-size: 30px;
      font-weight: 700;
    }

    .desc {
      margin-top: 15px;
      color: rgba(255, 255, 255, .75);
      line-height: 1.8;
      font-size: 16px;
    }

    .quote {
      margin-top: 20px;
      font-size: 14px;
      color: rgba(255, 255, 255, .5);
      font-style: italic;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-top: 35px;
      padding: 16px 30px;
      text-decoration: none;
      border-radius: 18px;
      font-weight: 600;
      color: white;
      background: linear-gradient(135deg, #2563eb, #7c3aed);
      box-shadow: 0 10px 30px rgba(99, 102, 241, .4);
      transition: .35s ease;
    }

    .btn:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(99, 102, 241, .5);
    }

    .footer {
      margin-top: 25px;
      font-size: 12px;
      color: rgba(255, 255, 255, .4);
    }

    @media(max-width: 600px) {
      .card {
        padding: 35px 25px;
      }

      .code {
        font-size: 70px;
      }

      h2 {
        font-size: 24px;
      }
    }
  </style>
</head>

<body>

  <div class="bubble one"></div>
  <div class="bubble two"></div>

  <div class="card">

    <div class="emoji">🚫😹</div>

    <div class="code">403</div>

    <h2>Eits... Akses Ditolak</h2>

    <p class="desc">
      Sepertinya kamu mencoba membuka gerbang rahasia 🏰<br>
      Tapi role kamu belum cukup sakti untuk masuk ke wilayah ini.
    </p>

    <p class="quote">
      “Naik level dulu ya, pendekar sistem...” 🥷
    </p>

    <a href="{{ url('/') }}" class="btn">
      🏠 Balik ke Beranda
    </a>

    <div class="footer">
      Permission denied • Laravel Security Shield
    </div>

  </div>

</body>

</html>