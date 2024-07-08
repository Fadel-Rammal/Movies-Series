from flask import Flask, render_template, request
from flask_cors import CORS
from imdb import IMDb

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

def get_top_5_actor_roles(movie_title):
    ia = IMDb()
    movies = ia.search_movie(movie_title)
    if movies:
        movie_id = movies[0].movieID
        movie = ia.get_movie(movie_id)
        actors = movie.get('cast')
        top_5_actors = []
        for i, actor in enumerate(actors):
            if i >= 5:
                break
            actor_info = {}
            actor_name = actor['name']
            role = actor.currentRole
            actor_info['name'] = actor_name
            actor_info['role'] = role
            # Fetch actor's image URL
            actor_obj = ia.get_person(actor.personID)
            headshot_url = actor_obj.get('headshot')
            actor_info['image_url'] = headshot_url if headshot_url else None
            top_5_actors.append(actor_info)
        return top_5_actors
    else:
        return None

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/search', methods=['POST'])
def search():
    movie_title = request.form['movie_title']
    top_5_actors = get_top_5_actor_roles(movie_title)
    if top_5_actors:
        return render_template('result.html', movie_title=movie_title, top_5_actors=top_5_actors)
    else:
        return render_template('result.html', movie_title=movie_title, message="Movie not found.")

if __name__ == "__main__":
    app.run(debug=True)
