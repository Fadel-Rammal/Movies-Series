package com.example.moviesseries;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity {

    private EditText etEmail, etPassword;
    private String email, password;


    //instead ip address write your ip address for example: 123.123.12.123 and then the path of login.php
    //of the mobile app
    private String URL = "http://ip address/M&S/M&S/Mobile/login.php";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        email = password = "";
        etEmail = findViewById(R.id.etEmail);
        etPassword = findViewById(R.id.etPassword);


        // Check if the user is already logged in
        SharedPreferences preferences = getSharedPreferences("MyPrefs", MODE_PRIVATE);
        String userID = preferences.getString("userID", "");

        if (!userID.isEmpty()) {
            // If userID is not empty, means user is already logged in, navigate to Success activity
            Intent intent = new Intent(MainActivity.this, Success.class);
            startActivity(intent);
            finish(); // Finish MainActivity to prevent user from going back to it using back button
        }
    }

    public void login(View view) {
        email = etEmail.getText().toString().trim();
        password = etPassword.getText().toString().trim();
        if (!email.equals("") && !password.equals("")) {
            StringRequest stringRequest = new StringRequest(Request.Method.POST, URL, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("res", response);
                    try {
                        JSONObject jsonResponse = new JSONObject(response);
                        String status = jsonResponse.getString("status");

                        if (status.equals("success")) {
                            String email = jsonResponse.getString("email");
                            String userID = jsonResponse.getString("userID");

                            // Save userID in SharedPreferences with key "userID"
                            SharedPreferences preferences = getSharedPreferences("MyPrefs", MODE_PRIVATE);
                            SharedPreferences.Editor editor = preferences.edit();
                            editor.putString("userID", userID);
                            editor.apply();

                            Intent intent = new Intent(MainActivity.this, Success.class);
                            intent.putExtra("email", email); // Pass email to Success activity
                            //intent.putExtra("userID", userID); // Pass userID to Success activity
                            startActivity(intent);
                            finish();
                        } else if (status.equals("failure")) {
                            Toast.makeText(MainActivity.this, "Invalid Login Id/Password", Toast.LENGTH_SHORT).show();
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Log.e("JSON Parse Error", "Response: " + response);
                        Toast.makeText(MainActivity.this, "Error parsing JSON response", Toast.LENGTH_SHORT).show();
                    }
                }

            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(MainActivity.this, error.toString().trim(), Toast.LENGTH_SHORT).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> data = new HashMap<>();
                    data.put("email", email);
                    data.put("password", password);
                    return data;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
            requestQueue.add(stringRequest);
        } else {
            Toast.makeText(this, "Fields can not be empty!", Toast.LENGTH_SHORT).show();
        }
    }



}
