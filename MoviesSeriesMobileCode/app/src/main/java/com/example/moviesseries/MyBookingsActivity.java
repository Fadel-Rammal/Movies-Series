package com.example.moviesseries;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class MyBookingsActivity extends AppCompatActivity {


    private static final String TAG = MyBookingsActivity.class.getSimpleName();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_bookings);

        // Retrieve user ID from Intent extra
        //String userID = getIntent().getStringExtra("userID");

        // Retrieve user ID from SharedPreferences
        SharedPreferences preferences = getSharedPreferences("MyPrefs", MODE_PRIVATE);
        String userID = preferences.getString("userID", "");


        //Display user ID in TextView
        //TextView userIDTextView = findViewById(R.id.userIDTextView);
        //userIDTextView.setText("User ID: " + userID);

        // Fetch user's bookings from server
        new FetchUserBookings().execute(userID);
    }

    private class FetchUserBookings extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            String userID = params[0];


            //instead ip address write your ip address for example: 123.123.12.123 and then the path of
            //get_user_bookings.php of the mobile app

            String urlStr = "http://ip address/M&S/M&S/Mobile/get_user_bookings.php?userID=" + userID;

            try {
                URL url = new URL(urlStr);
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");

                StringBuilder response = new StringBuilder();
                BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                String line;

                while ((line = reader.readLine()) != null) {
                    response.append(line);
                }

                reader.close();
                connection.disconnect();

                return response.toString();
            } catch (IOException e) {
                Log.e(TAG, "Error fetching user bookings", e);
            }

            return null;
        }

        @Override
        protected void onPostExecute(String resultJson) {
            super.onPostExecute(resultJson);
            if (resultJson != null) {
                Log.d(TAG, "Response from server: " + resultJson);

                try {
                    JSONArray jsonArray = new JSONArray(resultJson);

                    LinearLayout bookingsLayout = findViewById(R.id.bookingsLayout);
                    bookingsLayout.removeAllViews(); // Clear any existing views

                    // Display a message indicating no response from the server
                    TextView bookTextView = new TextView(MyBookingsActivity.this);
                    bookTextView.setText("Your Bookings:");
                    bookTextView.setTextColor(getResources().getColor(android.R.color.black));
                    // Set gravity to center_horizontal to center the text within the parent LinearLayout
                    bookTextView.setGravity(Gravity.CENTER_HORIZONTAL);
                    bookingsLayout.addView(bookTextView);


                    // Loop through the JSON array
                    for (int i = 0; i < jsonArray.length(); i++) {
                        JSONObject jsonObject = jsonArray.getJSONObject(i);


                        // Print booking number
                        TextView bookingNumberTextView = new TextView(MyBookingsActivity.this);
                        bookingNumberTextView.setText("Booking " + (i + 1));
                        bookingNumberTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(bookingNumberTextView);

                        // Create TextViews for each booking data
                        TextView roomnbTextView = new TextView(MyBookingsActivity.this);
                        roomnbTextView.setText("Room Number: " + jsonObject.getString("roomnb"));
                        roomnbTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(roomnbTextView);

                        TextView shownbTextView = new TextView(MyBookingsActivity.this);
                        shownbTextView.setText("Show Number: " + jsonObject.getString("shownb"));
                        shownbTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(shownbTextView);

                        TextView bookingIDTextView = new TextView(MyBookingsActivity.this);
                        bookingIDTextView.setText("Booking ID: " + jsonObject.getString("booking_id"));
                        bookingIDTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(bookingIDTextView);

                        TextView userIDBookingTextView = new TextView(MyBookingsActivity.this);
                        userIDBookingTextView.setText("User ID: " + jsonObject.getString("user_id"));
                        userIDBookingTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(userIDBookingTextView);

                        TextView seatIDTextView = new TextView(MyBookingsActivity.this);
                        seatIDTextView.setText("Seat ID: " + jsonObject.getString("seat_id"));
                        seatIDTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(seatIDTextView);

                        TextView movieTitleTextView = new TextView(MyBookingsActivity.this);
                        movieTitleTextView.setText("Movie Name: " + jsonObject.getString("movietitle"));
                        movieTitleTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(movieTitleTextView);

                        TextView cinemalocTextView = new TextView(MyBookingsActivity.this);
                        cinemalocTextView.setText("Cinema Location: " + jsonObject.getString("cinemaloc"));
                        cinemalocTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(cinemalocTextView);

                        TextView cinemanamTextView = new TextView(MyBookingsActivity.this);
                        cinemanamTextView.setText("Cinema Name: " + jsonObject.getString("cinemanam"));
                        cinemanamTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(cinemanamTextView);

                        TextView userTextView = new TextView(MyBookingsActivity.this);
                        userTextView.setText("User Name: " + jsonObject.getString("user"));
                        userTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(userTextView);

                        TextView start_timeTextView = new TextView(MyBookingsActivity.this);
                        start_timeTextView.setText("Start_time: " + jsonObject.getString("start_time"));
                        start_timeTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(start_timeTextView);

                        TextView end_timeTextView = new TextView(MyBookingsActivity.this);
                        end_timeTextView.setText("End_time: " + jsonObject.getString("end_time"));
                        end_timeTextView.setTextColor(getResources().getColor(android.R.color.black));
                        bookingsLayout.addView(end_timeTextView);

                        // Add a button
                        Button qrButton = new Button(MyBookingsActivity.this);
                        qrButton.setBackgroundColor(getResources().getColor(R.color.yellow)); // Set background color
                        qrButton.setTextColor(Color.WHITE); // Set text color to white
                        qrButton.setText("Generate QR code");
                        qrButton.setOnClickListener(new View.OnClickListener() {

                            @Override
                            public void onClick(View v) {
                                try {
                                    // Handle button click event (e.g., cancel booking)
                                    // Generate booking data for the QR code
                                    String bookingData = "Room Number: " + jsonObject.getString("roomnb") + "\n" + "Show Number: " + jsonObject.getString("shownb") + "\n"
                                            + "Booking ID: " + jsonObject.getString("booking_id") + "\n" +
                                            "User ID: " + jsonObject.getString("user_id") + "\n" +
                                            "Seat ID: " + jsonObject.getString("seat_id") + "\n" +
                                            "Movie Name: " + jsonObject.getString("movietitle")+ "\n"+
                                            "User Name: " + jsonObject.getString("user") + "\n" +
                                            "Start Time: " + jsonObject.getString("start_time") + "\n" +
                                            "End Time: " + jsonObject.getString("end_time") + "\n" ;

                                    // Start QRCodeActivity and pass booking data as an extra
                                    Intent intent = new Intent(MyBookingsActivity.this, QRCodeActivity.class);
                                    intent.putExtra("bookingData", bookingData);
                                    startActivity(intent);
                                } catch (JSONException e) {
                                    Log.e(TAG, "Error parsing JSON", e);
                                }
                            }



                        });
                        bookingsLayout.addView(qrButton);



                        Button viewLocationButton = new Button(MyBookingsActivity.this);

                        viewLocationButton.setTextColor(Color.WHITE); // Set text color to white
                        viewLocationButton.setText("View Location");
                        viewLocationButton.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                try {
                                    // Extract the location link from the JSON data
                                    String locationLink = jsonObject.getString("locationlink");

                                    // Extract latitude and longitude using a regex
                                    String regex = "2d([\\d.]+)!3d([\\d.]+)";
                                    Pattern pattern = Pattern.compile(regex);
                                    Matcher matcher = pattern.matcher(locationLink);

                                    String latitude = "";
                                    String longitude = "";
                                    if (matcher.find()) {
                                        longitude = matcher.group(1);
                                        latitude = matcher.group(2);
                                    }

                                    if (!latitude.isEmpty() && !longitude.isEmpty()) {
                                        // Construct the Google Maps URI
                                        String locationUri = "geo:" + latitude + "," + longitude + "?q=" + latitude + "," + longitude + "(Location)";

                                        // Create an Intent to launch Google Maps
                                        Intent mapIntent = new Intent(Intent.ACTION_VIEW, Uri.parse(locationUri));
                                        mapIntent.setPackage("com.google.android.apps.maps");

                                        // Check if Google Maps app is installed
                                        if (mapIntent.resolveActivity(getPackageManager()) != null) {
                                            startActivity(mapIntent);
                                        } else {
                                            // Handle if Google Maps app is not installed
                                            Log.e(TAG, "Google Maps app is not installed");
                                            // Optionally, redirect to the web browser version of Google Maps
                                            startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("https://www.google.com/maps/search/?api=1&query=" + latitude + "," + longitude)));
                                        }
                                    } else {
                                        Log.e(TAG, "Unable to extract latitude and longitude from the link");
                                    }
                                } catch (JSONException e) {
                                    Log.e(TAG, "Error parsing JSON", e);
                                }
                            }
                        });

                        bookingsLayout.addView(viewLocationButton);







                        // Add some space between bookings
                        TextView spacer = new TextView(MyBookingsActivity.this);
                        spacer.setText(""); // Empty text to act as spacer
                        bookingsLayout.addView(spacer);
                    }
                } catch (JSONException e) {
                    Log.e(TAG, "Error parsing JSON", e);
                }
            } else {
                Log.e(TAG, "No response from server");

            }
        }

    }
}