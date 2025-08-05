from flask import Flask, render_template, request, redirect, url_for, session
import sqlite3

app = Flask(__name__)
app.secret_key = 'tu_clave_secreta'  # Cambia esto por una clave segura

# Conexión a la base de datos SQLite
def get_db_connection():
    conn = sqlite3.connect('base_de_datos.db')
    conn.row_factory = sqlite3.Row
    return conn

@app.route('/')
def index():
    if 'usuario' not in session:
        return redirect(url_for('login'))
    return render_template('index.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        # Aquí deberías agregar el código para verificar las credenciales del usuario
        session['usuario'] = request.form['usuario']  # Suponiendo que el usuario se loguea con este formulario
        return redirect(url_for('index'))
    return render_template('login.html')

@app.route('/agregar_articulo', methods=['GET', 'POST'])
def agregar_articulo():
    if 'usuario' not in session:
        return redirect(url_for('login'))

    if request.method == 'POST':
        titulo = request.form['titulo'].strip()
        contenido = request.form['contenido'].strip()

        # Evitar inyección SQL utilizando parámetros
        conn = get_db_connection()
        conn.execute('INSERT INTO articulos (titulo, contenido) VALUES (?, ?)', (titulo, contenido))
        conn.commit()
        conn.close()

        return redirect(url_for('index'))
    
    return render_template('agregar_articulo.html')

if __name__ == '__main__':
    app.run(debug=True)


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Artículo - Wiki Star Wars</title>
    <style>
        body { font-family: Arial; background-color: #0b0c10; color: #fff; padding: 20px; }
        form { background-color: #1f2833; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
        input, textarea { width: 100%; padding: 8px; margin: 8px 0; }
        button { background-color: #45a29e; color: white; padding: 10px; border: none; width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Nuevo Artículo</h2>
    <form method="post" action="">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="contenido" placeholder="Contenido" rows="10" required></textarea>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
