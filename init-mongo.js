db = db.getSiblingDB('todo_app');

db.createCollection('usuarios');
db.createCollection('tareas');

db.createUser({
  user: "mongoadmin",
  pwd: "123456",
  roles: [{ role: "readWrite", db: "todo_app" }]
});

// Base de datos para tests
db = db.getSiblingDB('todo_app_test');
db.createCollection('usuarios');
db.createCollection('tareas');

db.createUser({
  user: "mongoadmin",
  pwd: "123456",
  roles: [{ role: "readWrite", db: "todo_app_test" }]
});