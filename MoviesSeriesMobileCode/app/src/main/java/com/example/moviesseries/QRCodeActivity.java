package com.example.moviesseries;

import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class QRCodeActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_qr_code);

        // Receive booking data from intent extra
        String bookingData = getIntent().getStringExtra("bookingData");

        // Generate QR code and display it in the ImageView
        ImageView qrCodeImageView = findViewById(R.id.qrCodeImageView);
        QRCodeGenerator.generateQRCode(bookingData, qrCodeImageView);

    }

    public void goBack(View view) {
        // Finish the current activity and return to the previous one
        finish();
    }




}