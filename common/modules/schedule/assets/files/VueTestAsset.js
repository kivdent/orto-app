Vue.component('todo-item', {
    template: `
    <tr>
       <th>{{todoId}}</th>
       <td>Область</td>
       <td> {{ title }}</td>
       <td>{{ price }}</td>
       <td>Срок</td>
       <td>Коммент</td>
       <td><button v-on:click="$emit('remove')">Удалить</button></td>
   </tr>
  `,
    props: ['title', 'price','todoId']
})

Vue.component('plan-unit', {
    template: `
<div class="panel panel-default">
    <div class="panel-heading">{{title}}<button v-on:click="$emit('remove-unit')">Удалить</button></div>
    <div class="panel-body">
    <unit-body></unit-body>
    </div>
</div>
    `,
    props: ['title']
})

Vue.component('unit-body', {
    data: function () {
        return {
            newTodoText: '',
            newPrice: '',
            nextTodoId: 2,
            todos: [
                {
                    id: 1,
                    title: 'Консультация',
                    price: '1000'
                }
            ]
        }
    },
    methods: {
        addNewTodo: function () {
            this.todos.push({
                id: this.nextTodoId++,
                title: this.newTodoText,
                price: this.newPrice
            })
            this.newTodoText = '',
                this.newPrice = ''
        }
    },
    template: `
    <div id="unit-body">
            <form v-on:submit.prevent="addNewTodo">
                <label for="new-todo">Элемент</label>
                <input
                        v-model="newTodoText"
                        id="new-todo"
                        placeholder="Название"
                ><input
                        v-model="newPrice"
                        id="new-price"
                        placeholder="Стоимость"
                >
                <button>Добавить</button>
            </form>
            <table class="table table-striped">
                <tr
                        is="todo-item"
                        v-for="(todo, index) in todos"
                        v-bind:key="todo.id"
                        v-bind:todoId="todo.id"
                        v-bind:title="todo.title"
                        v-bind:price="todo.price"
                        v-on:remove="todos.splice(index, 1)"
                ></tr>
            </table>
        </div> `
});

Vue.component('new-unit-form',{
    data: function () {
        return {
            newUnitTitle: ''
        }
    },
    methods: {
        addNewUnit: function () {
           vm.$data.units.push({
               id: vm.$data.nextUnitId++,
               title:this.newUnitTitle
           });
           this. newUnitTitle='';

        }
    },
    template: `
     <div id="new-unit-form">
        <form v-on:submit.prevent="addNewUnit">
            <label for="new-unit-title">Новый раздел плана лечения</label>
            <input
                    id="new-unit-title"
                    v-model="newUnitTitle"
                    placeholder="Название">
            <button>Создать</button>
        </form>
    </div>
     `,

});
let vm=new Vue({
    el: '#plan',
    data: {
        newTitleText: '',
        nextUnitId: 3,
        units: [
            {
                id: 1,
                title: 'Диагностический раздел'
            },
            {
                id: 2,
                title: 'Хирургический раздел'
            }
        ]
    }
})