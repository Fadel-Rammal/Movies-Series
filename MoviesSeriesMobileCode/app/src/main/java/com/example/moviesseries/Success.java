package com.example.moviesseries;

import static android.content.ContentValues.TAG;

import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.denzcoskun.imageslider.ImageSlider;
import com.denzcoskun.imageslider.constants.ScaleTypes;
import com.denzcoskun.imageslider.models.SlideModel;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.ArrayList;

public class Success extends AppCompatActivity {

    // Declare userID as a class member
    private String userID;

    // Constants for SharedPreferences
    private static final String PREF_NAME = "MyPrefs";
    private static final String PREF_USER_ID = "userID";

    private static final String PREF_NOTIFICATION_ENABLED = "pref_notification_enabled";

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.success);

        // Retrieve userID from SharedPreferences
        SharedPreferences preferences = getSharedPreferences("MyPrefs", MODE_PRIVATE);
        userID = preferences.getString("userID", ""); // Assign value to class-level userID variable



        ImageSlider imageSlider = findViewById(R.id.imageSlider);
        ArrayList<SlideModel> slideModels = new ArrayList<>();

        slideModels.add(new SlideModel(R.drawable.banner1, ScaleTypes.FIT));
        slideModels.add(new SlideModel(R.drawable.banner2, ScaleTypes.FIT));
        slideModels.add(new SlideModel(R.drawable.banner3, ScaleTypes.FIT));
        slideModels.add(new SlideModel(R.drawable.banner4, ScaleTypes.FIT));


        imageSlider.setImageList(slideModels, ScaleTypes.FIT);

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);



        //userID = getIntent().getStringExtra("userID"); // Assign value to class-level userID variable



        // Subscribe to "News" topic when the activity is created
        subscribeToNewsTopic();

        // Set default notification preference if not already set
        setDefaultNotificationPreference();
        // Update button text based on current notification preference
        updateNotificationButton();

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.action_logout) {
            Log.d(TAG, "Logout menu item clicked");
            // Perform logout action
            logout();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }


    // Method to handle button click for "Logout"
    public void logout() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Logout");
        builder.setMessage("Are you sure you want to log out?");
        builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                // Clear userID from SharedPreferences
                SharedPreferences preferences = getSharedPreferences(PREF_NAME, MODE_PRIVATE);
                SharedPreferences.Editor editor = preferences.edit();
                editor.remove(PREF_USER_ID);
                editor.apply();

                // Redirect to MainActivity
                Intent intent = new Intent(Success.this, MainActivity.class);
                startActivity(intent);
                finish(); // Close the current activity to prevent going back to it using the back button
            }
        });
        builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                // Dismiss the dialog if "No" is clicked
                dialogInterface.dismiss();
            }
        });
        builder.show();
    }


    public void onNotificationSettingsClicked(View view) {
        // Handle click event for notification settings button
        showNotificationConfirmationDialog();
    }

    private void setDefaultNotificationPreference() {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(this);
        if (!sharedPreferences.contains(PREF_NOTIFICATION_ENABLED)) {
            // Notification preference not set, set it to false (disabled) by default
            SharedPreferences.Editor editor = sharedPreferences.edit();
            editor.putBoolean(PREF_NOTIFICATION_ENABLED, false);
            editor.apply();
        }
    }

    private void subscribeToNewsTopic() {
        FirebaseMessaging.getInstance().subscribeToTopic("News")
                .addOnCompleteListener(new OnCompleteListener<Void>() {
                    @Override
                    public void onComplete(Task<Void> task) {
                        if (task.isSuccessful()) {
                            // Notification subscription successful
                        } else {
                            // Notification subscription failed
                        }
                    }
                });
    }

    private void showNotificationConfirmationDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Notification Settings");
        builder.setMessage("Do you want to enable/disable notifications?");
        builder.setPositiveButton("Enable", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                // Enable notifications
                setNotificationEnabled(true);
            }
        });
        builder.setNegativeButton("Disable", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                // Disable notifications
                setNotificationEnabled(false);
            }
        });
        builder.show();
    }

    private void setNotificationEnabled(boolean enabled) {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(this);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putBoolean(PREF_NOTIFICATION_ENABLED, enabled);
        editor.apply();

        Button notificationButton = findViewById(R.id.button_notification);

        if (enabled) {
            // Subscribe to the "News" topic if notifications are enabled
            subscribeToNewsTopic();
            notificationButton.setText("Notification: Enabled");
            Toast.makeText(Success.this, "Notifications enabled", Toast.LENGTH_SHORT).show();
        } else {
            // Unsubscribe from the "News" topic if notifications are disabled
            FirebaseMessaging.getInstance().unsubscribeFromTopic("News");
            notificationButton.setText("Notification: Disabled");
            Toast.makeText(Success.this, "Notifications disabled", Toast.LENGTH_SHORT).show();
        }
    }

    private void updateNotificationButton() {
        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(this);
        boolean notificationEnabled = sharedPreferences.getBoolean(PREF_NOTIFICATION_ENABLED, false);
        Button notificationButton = findViewById(R.id.button_notification);

        if (notificationEnabled) {
            notificationButton.setText("Notification: Enabled");
        } else {
            notificationButton.setText("Notification: Disabled");
        }
    }





    // Method to handle button click for "My Bookings"
    public void goToMyBookingsActivity(View view) {
        Intent intent = new Intent(this, MyBookingsActivity.class);
        intent.putExtra("userID", userID); // Pass the user ID as an extra
        startActivity(intent);
    }
}


