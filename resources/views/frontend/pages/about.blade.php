@extends('frontend.layouts.app')

@section('title', 'About Us - Auto Parts Market')

@section('style')
    <style>
        /* ===== ABOUT PAGE STYLE ===== */
        main {
            background: #f8f8f8;
        }

        .about-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            color: #333;
            line-height: 1.8;
        }

        .about-hero {
            background: linear-gradient(to right, #ff8c00, #ffb84d);
            color: #fff;
            padding: 80px 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 50px;
        }

        .about-hero h1 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .about-hero p {
            font-size: 18px;
            font-weight: 500;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 60px;
        }

        .about-content img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .about-text h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #222;
        }

        .about-text p {
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            text-align: center;
            background: #f8f8f8;
            padding: 40px 20px;
            border-radius: 10px;
            margin-bottom: 60px;
        }

        .stat-item h3 {
            color: #ff6600;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .stat-item p {
            font-size: 15px;
            color: #555;
        }

        /* ===== TEAM SECTION ===== */
        .team-section {
            text-align: center;
        }

        .team-section h2 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .team-member {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .team-member:hover {
            transform: translateY(-5px);
        }

        .team-member img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .team-member h4 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #222;
        }

        .team-member p {
            font-size: 14px;
            color: #777;
        }

        @media (max-width: 768px) {
            .about-content {
                grid-template-columns: 1fr;
            }

            .stats {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <main class="about-section">
        <section class="about-hero">
            <h1>{{ $about->title ?? 'About Auto Parts Market' }}</h1>
            <p>{{ $about->subtitle ?? 'Your Trusted Destination for Quality Auto Parts' }}</p>

        </section>

        <section class="about-content">
            <div class="about-text">
                <h2>Who We Are</h2>
                <p>{{ $about->who_we_are }}</p>
                <p>{{ $about->our_story }}</p>
            </div>
            <div>
                <img src="{{ asset('storage/' . $about->image) }}" alt="About Auto Parts Market">
            </div>
        </section>

        <section class="stats">
            @foreach ($stats as $stat)
                <div class="stat-item">
                    <h3>{{ $stat->value }}</h3>
                    <p>{{ $stat->title }}</p>
                </div>
            @endforeach
        </section>

        <section class="team-section">
            <h2>Meet Our Team</h2>
            <div class="team-grid">
                @foreach ($team as $member)
                    <div class="team-member">
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                        <h4>{{ $member->name }}</h4>
                        <p>{{ $member->role }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

@endsection
