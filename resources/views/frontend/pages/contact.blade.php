@extends('frontend.layouts.app')

@section('title', 'Contact Us - Auto Parts Market')

@section('style')
    <style>
        /* ===== CONTACT PAGE STYLE ===== */
        main {
            background: #f8f8f8;
        }

        .contact-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .contact-header h1 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #222;
        }

        .contact-header p {
            font-size: 18px;
            color: #555;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .contact-info {
            background: linear-gradient(135deg, #a12406, #ff6f00);
            color: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .contact-info:hover {
            transform: translateY(-5px);
        }

        .contact-info h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .contact-info p {
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .contact-info p i {
            font-size: 20px;
            color: #fff;
            min-width: 25px;
        }


        .contact-form {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .contact-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #222;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            resize: none;
        }

        .contact-form button {
            background-color: #ff6600;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .contact-form button:hover {
            background-color: #e55b00;
        }

        .map-container {
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 15px;
            margin-top: 40px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .map-container iframe {
            width: 100%;
            height: 450px;

            border: none;
        }

        @media (max-width: 768px) {
            .map-container iframe {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .map-container iframe {
                height: 200px;
            }
        }
    </style>
@endsection

@section('content')
<main class="contact-section">
    <section class="contact-header">
        <h1>{{ $contactPage->title ?? 'Contact' }}</h1>
        <p>{{ $contactPage->description ?? 'Have a question !' }}</p>
    </section>

    <section class="contact-content">
        <div class="contact-info">
            <h2>Our Information</h2>
            <p><strong>Address:</strong> {{ $contactPage->address ?? 'Dhaka, Bangladesh' }}</p>
            <p><strong>Phone:</strong> {{ $contactPage->phone ?? '+880 1234 567 ' }}</p>
            <p><strong>Email:</strong> {{ $contactPage->email ?? 'support@.com' }}</p>
            <p><strong>Working Hours:</strong> {{ $contactPage->working_hours ?? ' - 6:00 PM' }}</p>
        </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2>Send Us a Message</h2>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="phone" name="phone" placeholder="Your Phone (Optional)" >
                    <input type="text" name="subject" placeholder="Subject" required>
                    <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </section>

        <section class="map-section">
        <div class="map-container">
            {!! $contactPage->map_iframe ?? '' !!}
        </div>
    </section>

    </main>
@endsection
