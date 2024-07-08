import tkinter as tk
import vlc
from tkinter import filedialog
from datetime import timedelta
import mysql.connector
import bcrypt
from threading import Thread
import tempfile
from tkinter import messagebox

def xor_decrypt(input_bytes, key):
    output = bytearray()
    for i in range(len(input_bytes)):
        output.append(input_bytes[i] ^ ord(key[i % len(key)]))
    return bytes(output)

class MediaPlayerApp(tk.Tk):
    def __init__(self):
        super().__init__()
        self.title("Media Player")
        self.geometry("800x600")
        self.configure(bg="#f0f0f0")
        self.initialize_player()

    def initialize_player(self):
        self.instance = vlc.Instance()
        self.media_player = self.instance.media_player_new()
        self.current_file = None
        self.playing_video = False
        self.video_paused = False
        self.encryption_key = None
        self.create_widgets()

    def create_widgets(self):
        self.media_canvas = tk.Canvas(self, bg="black", width=800, height=400)
        self.media_canvas.pack(pady=10, fill=tk.BOTH, expand=True)
        self.select_file_button = tk.Button(
            self,
            text="Select File",
            font=("Arial", 12, "bold"),
            command=self.select_file,
        )
        self.select_file_button.pack(pady=5)
        self.time_label = tk.Label(
            self,
            text="00:00:00 / 00:00:00",
            font=("Arial", 12, "bold"),
            fg="#555555",
            bg="#f0f0f0",
        )
        self.time_label.pack(pady=5)
        self.control_buttons_frame = tk.Frame(self, bg="#f0f0f0")
        self.control_buttons_frame.pack(pady=5)
        self.play_button = tk.Button(
            self.control_buttons_frame,
            text="Play",
            font=("Arial", 12, "bold"),
            bg="#4CAF50",
            fg="white",
            command=self.play_video,
        )
        self.play_button.pack(side=tk.LEFT, padx=5, pady=5)
        self.pause_button = tk.Button(
            self.control_buttons_frame,
            text="Pause",
            font=("Arial", 12, "bold"),
            bg="#FF9800",
            fg="white",
            command=self.pause_video,
        )
        self.pause_button.pack(side=tk.LEFT, padx=10, pady=5)
        self.stop_button = tk.Button(
            self.control_buttons_frame,
            text="Stop",
            font=("Arial", 12, "bold"),
            bg="#F44336",
            fg="white",
            command=self.stop,
        )
        self.stop_button.pack(side=tk.LEFT, pady=5)
        self.fast_forward_button = tk.Button(
            self.control_buttons_frame,
            text="Fast Forward",
            font=("Arial", 12, "bold"),
            bg="#2196F3",
            fg="white",
            command=self.fast_forward,
        )
        self.fast_forward_button.pack(side=tk.LEFT, padx=10, pady=5)
        self.rewind_button = tk.Button(
            self.control_buttons_frame,
            text="Rewind",
            font=("Arial", 12, "bold"),
            bg="#2196F3",
            fg="white",
            command=self.rewind,
        )
        self.rewind_button.pack(side=tk.LEFT, pady=5)
        self.progress_bar = VideoProgressBar(
            self, self.set_video_position, bg="#e0e0e0", highlightthickness=0
        )
        self.progress_bar.pack(fill=tk.X, padx=10, pady=5)

    def select_file(self):
        file_path = filedialog.askopenfilename(
            filetypes=[("Media Files", "*.mp4 *.avi")]
        )
        if file_path:
            self.current_file = file_path
            self.stop()  # Stop the currently playing video     
            self.decrypt_and_play_video()  # Decrypt and play the new video
            


    def decrypt_and_play_video(self):
        # Decrypt the video file in the background
        decryption_thread = Thread(target=self.decrypt_video_thread, args=(self.current_file,))
        decryption_thread.start()

    def decrypt_video_thread(self, file_path):
        try:
            # Connect to MySQL database
            conn = mysql.connector.connect(
                host="localhost",
                user="root",
                password="",
                database="Movies&Series"
            )
            cursor = conn.cursor()

            # Get encryption key for the logged-in user
            query = "SELECT encryption_key FROM userinfo WHERE email = %s"
            cursor.execute(query, (logged_in_user_email,))
            encryption_key = cursor.fetchone()[0]

            # Read encrypted video file
            with open(file_path, 'rb') as f:
                encrypted_data = f.read()

            # Decrypt the video file
            decrypted_data = xor_decrypt(encrypted_data, encryption_key)

            # Play the decrypted video
            self.play_decrypted_video(decrypted_data)

        except mysql.connector.Error as e:
            print("Error connecting to MySQL:", e)

    def play_decrypted_video(self, decrypted_data):
        # Create a temporary file in memory
        with tempfile.NamedTemporaryFile(suffix=".mp4", delete=False) as temp_file:
            temp_file.write(decrypted_data)
            temp_file.seek(0)  # Reset file pointer to the beginning
            self.current_file = temp_file.name
            self.play_video()

    def play_video(self):
        if not self.playing_video:
            media = self.instance.media_new(self.current_file)
            self.media_player.set_media(media)
            self.media_player.set_hwnd(self.media_canvas.winfo_id())
            self.media_player.play()
            self.playing_video = True

    def fast_forward(self):
        if self.playing_video:
            current_time = self.media_player.get_time() + 10000
            self.media_player.set_time(current_time)

    def rewind(self):
        if self.playing_video:
            current_time = self.media_player.get_time() - 10000
            self.media_player.set_time(current_time)

    def pause_video(self):
        if self.playing_video:
            if self.video_paused:
                self.media_player.play()
                self.video_paused = False
                self.pause_button.config(text="Pause")
            else:
                self.media_player.pause()
                self.video_paused = True
                self.pause_button.config(text="Resume")

    def stop(self):
        if self.playing_video:
            self.media_player.stop()
            self.playing_video = False
        self.time_label.config(text="00:00:00 / " + self.get_duration_str())

    def get_duration_str(self):
        if self.playing_video:
            total_duration = self.media_player.get_length()
            total_duration_str = str(timedelta(milliseconds=total_duration))[:-3]
            return total_duration_str
        return "00:00:00"

    def set_video_position(self, value):
        if self.playing_video:
            total_duration = self.media_player.get_length()
            position = int((float(value) / 100) * total_duration)
            self.media_player.set_time(position)

    def update_video_progress(self):

        try:

           if self.playing_video:
               total_duration = self.media_player.get_length()
               current_time = self.media_player.get_time()
               progress_percentage = (current_time / total_duration) * 100
               self.progress_bar.set(progress_percentage)
               current_time_str = str(timedelta(milliseconds=current_time))[:-3]
               total_duration_str = str(timedelta(milliseconds=total_duration))[:-3]
               self.time_label.config(text=f"{current_time_str} / {total_duration_str}")
           self.after(1000, self.update_video_progress)
        except ZeroDivisionError:
           # Display pop-up message
           tk.messagebox.showerror("Decryption Failed", "The Application Will Close! \n Incorrect Key \n Chosen Video is Wrong")
           self.destroy()  # Close the application


class VideoProgressBar(tk.Scale):
    def __init__(self, master, command, **kwargs):
        kwargs["showvalue"] = False
        super().__init__(
            master,
            from_=0,
            to=100,
            orient=tk.HORIZONTAL,
            length=800,
            command=command,
            **kwargs,
        )
        self.bind("<Button-1>", self.on_click)

    def on_click(self, event):
        if self.cget("state") == tk.NORMAL:
            value = (event.x / self.winfo_width()) * 100
            self.set(value)


def login():
    global logged_in_user_email  # Make the variable accessible outside the function
    email = email_entry.get()
    password = password_entry.get()

    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="Movies&Series"
        )

        cursor = conn.cursor()

        query = "SELECT * FROM userinfo WHERE email = %s"
        cursor.execute(query, (email,))
        user = cursor.fetchone()

        if user:
            if bcrypt.checkpw(password.encode('utf-8'), user[4].encode('utf-8')):
                # Password matches
                logged_in_user_email = email
                login_window.destroy()
                app = MediaPlayerApp()
                app.update_video_progress()
                app.mainloop()
            else:
                error_label.config(text="Password does not match")
        else:
            error_label.config(text="Email not found")

    except mysql.connector.Error as e:
        print("Error connecting to MySQL:", e)


login_window = tk.Tk()
login_window.title("Login")

tk.Label(login_window, text="Email:").grid(row=0, column=0)
tk.Label(login_window, text="Password:").grid(row=1, column=0)

email_entry = tk.Entry(login_window)
password_entry = tk.Entry(login_window, show="*")
login_button = tk.Button(login_window, text="Login", command=login)
error_label = tk.Label(login_window, text="")

email_entry.grid(row=0, column=1)
password_entry.grid(row=1, column=1)
login_button.grid(row=2, columnspan=2)
error_label.grid(row=3, columnspan=2)

login_window.mainloop()
