// Este script se ejecuta con privilegios de root admin
db = db.getSiblingDB('admin');

// Verificar que el usuario root existe
print('Usuario root configurado correctamente');

// Cambiar a la base de datos de la aplicación
db = db.getSiblingDB('todo_app');

// Crear colecciones
db.createCollection('usuarios');
db.createCollection('tareas');

print('Colecciones creadas en todo_app');

// Crear usuario específico para la aplicación (con privilegios de admin también)
try {
    db.createUser({
        user: "mongoadmin",
        pwd: "123456",
        roles: [
            { role: "readWrite", db: "todo_app" },
            { role: "dbAdmin", db: "todo_app" }
        ]
    });
    print('Usuario mongoadmin creado en todo_app');
} catch (e) {
    print('Usuario mongoadmin ya existe o error: ' + e);
}

// Base de datos para tests
db = db.getSiblingDB('todo_app_test');
db.createCollection('usuarios');
db.createCollection('tareas');

try {
    db.createUser({
        user: "mongoadmin",
        pwd: "123456",
        roles: [
            { role: "readWrite", db: "todo_app_test" },
            { role: "dbAdmin", db: "todo_app_test" }
        ]
    });
    print('Usuario mongoadmin creado en todo_app_test');
} catch (e) {
    print('Usuario mongoadmin ya existe en todo_app_test o error: ' + e);
}

print('Inicialización completada');