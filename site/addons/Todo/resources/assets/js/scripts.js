Vue.component('todos', {

    props: ['get', 'complete', 'add', 'delete'],

    data: function() {
        return {
            newTodo: {
                title: null
            },
            allTodos: {},
            ajax: {
                get: this.get,
                complete: this.complete,
                add: this.add,
                delete: this.delete
            }
        }
    },

    ready: function () {
        this.getOpenTodos();
    },

    methods: {
        getOpenTodos: function() {
            this.$http.get(this.ajax.get, function(data){
                this.allTodos = data.todos;
            }).error(function() {
                alert('There was a problem loading the Todos');
            })
        },
        
        addTodo: function() {
            this.$http.post(this.ajax.add, this.newTodo, function(data) {
                this.newTodo.title = null;
                this.allTodos.push(data);
                
            }).error(function(data) {
                alert('There was a problem adding the Todo');
            });
        },

        completeTodo: function(todo) {
            this.$http.put(this.ajax.complete, {id: todo.id}, function(data) {
                todo.completed = true;
                todo.completedAt = 'Just Now';
            }).error(function() {
                alert('There was a problem completing the Todo');
            });
        },
        trashTodo: function(todo) {
            this.$http.delete(this.ajax.delete, {id: todo.id}, function(data){
                this.allTodos.$remove(todo);
            }).error(function() {
                alert('There was a problem deleting the Todo');
            });
        }
    },
    computed: {
        hasOpenTodos: function() {
            var $totalOpen = 0;
            _.forEach(this.allTodos, function(value, key) {
                if(value.completed === false) {
                    $totalOpen++;
                }
            });

            return $totalOpen > 0;
        },
        hasCompletedTodos: function() {
            var $totalCompleted = 0;
            _.forEach(this.allTodos, function(value, key) {
                if(value.completed === true) {
                    $totalCompleted++;
                }
            });

            return $totalCompleted > 0;
        }
    }
});