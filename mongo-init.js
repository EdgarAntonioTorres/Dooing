db = db.getSiblingDB('todo_app');
db.createUser({
  user: 'mongoadmin',
  pwd: '123456',
  roles: [
    { role: 'readWrite', db: 'todo_app' }
  ]
});