/* jshint esversion: 6 */
const {createApp, ref, defineProps, provide, reactive, inject} = Vue;

const {createPinia} = Pinia;//Импортируем функцию создания Pinia

const pinia = createPinia();//Создаём объект

const {defineStore} = Pinia;//Импортируме функцию определения хранилища


let treatmentPlan = {//Создаём обект корневого компонента корневой компонент
    // data() {
    //     return {}
    // },
    setup() {
        const diagnosis = ref([]);
        const treatmentPlan = reactive({
            diagnosis: [],
            description: '',
            chapters: [],
        });

        const insertChapter = function (newChapter) {
            //this.newChapter.position = this.nextPosition;
            // this.nextPosition++;
            this.treatmentPlan.chapters.push(Object.assign({}, newChapter))
            this.dialogFormVisible = false;
            console.log(newChapter);
        };
        provide('treatmentPlan', treatmentPlan)
        provide('insertChapter', insertChapter)
        return {diagnosis, treatmentPlan, insertChapter};
    },
    methods: {
        async getDiagnosis() {
            const url = '/api/diagnosis';
            const res = await fetch(url);
            const data = await res.json();
            console.log(data);
            this.diagnosis = data;
        },

        diagnosisChange(treatmentPlanDiagnosis) {
            this.treatmentPlan.diagnosis = treatmentPlanDiagnosis;
        },

    },

    beforeMount() {
        this.getDiagnosis();
    },
    template: `
<div class="row">

    <div class="col-lg-3" >
        <select-diagnosis :diagnosis="diagnosis " @diagnosisChange="diagnosisChange"/>
     
    </div>
    
    <div class="col-lg-9">
        <plan-description @descriptionChange="(description)=>treatmentPlan.description=description"/>
         
    </div>
</div>
<el-divider />
<newChapterForm/>
<planChapter 
    v-for="(chapter,index) in treatmentPlan.chapters"
    :key="index"
    :chapter="chapter"
    :index="index"
></planChapter>
</div>
    `
}

let app = createApp(treatmentPlan);//создаём корневой компонент

app.use(ElementPlus);
app.use(pinia);

//Определяем хранилище для диагнозов. Используем Pinia

// const useDsStore = defineStore('dsStore', {
//     state: () => ({
//         diagnosis: [],
//         treatmentPlan: {
//             diagnosis: [],
//         }
//     }),
//     actions: {
//         async getDiagnosis() {
//             const url = '/api/diagnosis';
//             const res = await fetch(url);
//             const data = await res.json();
//             console.log(data);
//             this.diagnosis = data;
//         }
//     }
// })


app.component('select-diagnosis', {
    setup() {
        // const dsStore = useDsStore();//Используем хранилище для диагнозов в компоненте
        // dsStore.getDiagnosis();
        // return {dsStore};
        const treatmentPlanDiagnosis = ref([]);

        return {treatmentPlanDiagnosis}
    },
    props: ['diagnosis'],
    methods: {
        change() {
            this.$emit('diagnosisChange', this.treatmentPlanDiagnosis);
        },
    },

    template: `
     <el-select v-model="treatmentPlanDiagnosis" class="m-2" filterable multiple clearable placeholder="Диагноз" 
                @change="change">
            <el-option
                    v-for="item in diagnosis"
                    :key="item.id"
                    :label="item.code+' '+item.title"
                    :value="item.id"   
                    no-match-text="Диагноз не найден"
            />
        </el-select>
    `
});

app.component('plan-description', {
    setup() {
        const planComment = ref('');
        return {planComment};
    },

    template: `
     <el-input
    v-model="planComment"
   autosize
   
    type="textarea"
    placeholder="Описание плана лечения"
    @input="$emit('descriptionChange',this.planComment)"
  
  />
    `,

});

//форма нового раздела плана
app.component('newChapterForm', {
    setup() {
        const dialogFormVisible = ref(false)

        const newChapter = ref({
            position: '',
            title: '',
            description: ''
        })

        const nextPosition = 1;

        const treatmentPlan = inject('treatmentPlan');
        const insertChapter = inject('insertChapter');
        return {newChapter, nextPosition, dialogFormVisible, treatmentPlan, insertChapter};
    },
    methods: {
        onSubmit() {
            this.insertChapter(this.newChapter);
            this.newChapter={
                position: '',
                title: '',
                description: ''
            }
        }
    },
    template: `

    <el-button type="primary"  @click="dialogFormVisible = true">Новый раздел</el-button>
     <el-dialog v-model="dialogFormVisible" title="Новый раздел">
         <el-form :model="newChapter" class="demo-form-inline" >
              <el-form-item label="Название раздела">
                    <el-input v-model="newChapter.title" placeholder="Название" />
              </el-form-item>
              <el-form-item label="Описание">
                 <el-input
                 v-model="newChapter.description"
                 autosize
                 type="textarea"
                 placeholder="Описание"
                />
             </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">Создать</el-button>
           </el-form-item>
        </el-form>
        <template #footer>
        <span class="dialog-footer">
            <el-button @click="dialogFormVisible = false">Отмена</el-button>
            <el-button type="primary" @click="onSubmit">
             Создать
            </el-button>
      </span>
    </template>
  </el-dialog>
  {{treatmentPlan}}
    `
})
app.component('planChapter', {
    setup() {
        const treatmentPlan = inject('treatmentPlan');
        return {treatmentPlan};
    },
    props: ['chapter','index'],
    methods:{
        deleteChapter(){
            this.treatmentPlan.chapters.splice(this.index,1)
        }
    },
    template: `
    <el-card class="box-card">
    <template #header>
      <div class="card-header">
       <p>{{chapter.id}} {{chapter.title}} <el-button class="button" @click="deleteChapter">Удалить</el-button> <el-button class="button" @click="deleteChapter">Изменить</el-button></p> 
       <p>{{chapter.descriptions}}</p>
      </div>
    </template>
    
  </el-card>
    `,

});
app.mount('#treatmentPlan');
