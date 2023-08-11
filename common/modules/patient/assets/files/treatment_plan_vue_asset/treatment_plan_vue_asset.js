/* jshint esversion: 6 */
const {createApp, ref, defineProps, provide, reactive, inject} = Vue;

const {createPinia} = Pinia;//Импортируем функцию создания Pinia

const pinia = createPinia();//Создаём объект

const {defineStore} = Pinia;//Импортируме функцию определения хранилища


let treatmentPlan = {
    setup() {
        const diagnosis = ref([]);
        const regions = ref([]);
        const operations = ref([]);

        const treatmentPlan = reactive({
            diagnosis: [],
            description: '',
            chapters: [
                {
                    position: "",
                    title: "План диагностики",
                    description: "План подготовки к работе",
                    planItems: [
                        {
                            region_id: 1,
                            diagnosis_id: '',
                            operation_id: "",
                            price_from: '',
                            price_to: '',
                            duration_from: '',
                            duration_to: '',
                            comment: ''
                        }
                    ]
                }
            ],
        });

        const insertChapter = function (newChapter) {
            this.treatmentPlan.chapters.push(Object.assign({}, newChapter))
            this.dialogFormVisible = false;
            console.log(newChapter);
        };
        provide('treatmentPlan', treatmentPlan)
        provide('insertChapter', insertChapter)
        provide('regions', regions)
        provide('diagnosis', diagnosis)
        provide('operations', operations)
        return {diagnosis, treatmentPlan, insertChapter, regions, operations};
    },
    methods: {
        async getDiagnosis() {
            const url = '/api/diagnosis';
            const res = await fetch(url);
            const data = await res.json();
            console.log(data);
            this.diagnosis = data;
        },
        async getRegions() {
            const url = '/api/region';
            const res = await fetch(url);
            const data = await res.json();
            console.log(data);
            this.regions = data;
        },
        async getOperations() {
            const url = '/api/operations';
            const res = await fetch(url);
            const data = await res.json();
            console.log(data);
            this.operations = data;
        },

        diagnosisChange(treatmentPlanDiagnosis) {
            this.treatmentPlan.diagnosis = treatmentPlanDiagnosis;
        },

    },

    beforeMount() {
        this.getDiagnosis();
        this.getRegions();
        this.getOperations();
    },
    template: `
<div class="row">

    <div class="col-lg-3" >
        <select-diagnosis :diagnosis="diagnosis " @diagnosisChange="diagnosisChange"/>
     
    </div>
    
    <div class="col-lg-6">
        <plan-description @descriptionChange="(description)=>treatmentPlan.description=description"/>
         
    </div>
    <div class="col-lg-3">
        
         <select>
         <option>Согласован</option>
         <option>Выполняется</option>
         <option>Выполнен</option>
</select>
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
                @change="change" no-match-text="Диагноз не найден">
            <el-option
                    v-for="item in diagnosis"
                    :key="item.id"
                    :label="item.code+' '+item.title"
                    :value="item.id"   
                   
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
            description: '',
            planItems: [
                {
                    region_id: 1,
                    diagnosis_id: '',
                    operation_id: "",
                    price_from: '',
                    price_to: '',
                    duration_from: '',
                    duration_to: '',
                    comment: ''
                }
            ]
        })

        const nextPosition = 1;

        const treatmentPlan = inject('treatmentPlan');
        const insertChapter = inject('insertChapter');
        return {newChapter, nextPosition, dialogFormVisible, treatmentPlan, insertChapter};
    },
    methods: {
        onSubmit() {
            this.insertChapter(this.newChapter);
            this.newChapter = {
                position: '',
                title: '',
                description: '',
                planItems: [
                    {
                        region_id: 1,
                        diagnosis_id: '',
                        operation_id: "",
                        price_from: '',
                        price_to: '',
                        duration_from: '',
                        duration_to: '',
                        comment: ''
                    }
                ]
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
        const update = ref(false);
        const treatmentPlan = inject('treatmentPlan');

        return {treatmentPlan, update};
    },
    props: ['chapter', 'index'],
    methods: {
        deleteChapter() {
            this.treatmentPlan.chapters.splice(this.index, 1)
        },
        updateChapter() {
            this.update = false;
        },
        addPlanItem() {
            this.chapter.planItems.push({
                region_id: 1,
                diagnosis_id: '',
                operation_id: "",
            })
        }
    },
    template: `
    <el-card class="box-card">
    <template #header>
      <div class="card-header" v-show="!update">
      <el-row >
        <el-col :span="8">
            <strong>{{chapter.id}} {{chapter.title}}</strong> 
        </el-col>
        <el-col :span="8">
            {{chapter.description}}
        </el-col>
        <el-col :span="6">
     
            <el-button class="button" @click="update=true" size="small" type="primary">Изменить</el-button>
            <el-button class="button" @click="deleteChapter" size="small" type="danger">Удалить</el-button> 
        </el-col>
       </el-row>
       
      </div>
    <el-form :model="chapter" class="demo-form-inline" v-show="update">
              <el-form-item label="Название раздела">
                    <el-input v-model="chapter.title" placeholder="Название" />
              </el-form-item>
              <el-form-item label="Описание">
                 <el-input
                 v-model="chapter.description"
                 autosize
                 type="textarea"
                 placeholder="Описание"
                />
             </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="updateChapter">Сохранить</el-button>
           </el-form-item>
        </el-form>
        </template>
         <el-button class="button" @click="addPlanItem" size="small" type="primary">Добавить элемент</el-button><br>
        <planItem v-for="(planItem,index) in chapter.planItems"
                   :key="index"
                   :index="index"
                   :planItem="planItem"
                   :chapter="chapter">
                   
        </planItem>
  </el-card>
    `,

});
app.component('planItem', {
    setup() {
        return {};
    },
    props: ['index', 'planItem', 'chapter'],
    methods: {
        deletePlanItem() {
            this.chapter.planItems.splice(this.index, 1)
        },
        addPlanItem() {
            this.chapter.planItems.push({
                region_id: 1,
                diagnosis_id: '',
                operation_id: "",
                price_from: '',
                price_to: '',
                duration_from: '',
                duration_to: '',
                comment: '',
            })
        },

    },
    template: `
<el-form>
    <el-row :gutter="10">
      <el-col :span="10">
             <regionSelector :planItem="planItem"></regionSelector>
              <diagnosisSelector :planItem="planItem"></diagnosisSelector>
      </el-col>
        <el-col :span="8">
             <el-input v-model="planItem.comment" placeholder="Комментарий" size="small"/>
        </el-col>
         <el-col :span="6">
              <el-button class="button" @click="deletePlanItem" type="danger" size="small" >Удалить</el-button>
              <el-button class="button" @click="addPlanItem"  type="primary" size="small">Добавить</el-button> 
         </el-col>

    </el-row>
    <el-row  :gutter="20">
         <el-col :span="5">
              <operationSelector :planItem="planItem"></operationSelector>
        </el-col>
        <el-col :span="4">
             <el-input v-model="planItem.price_from" placeholder="Цена от" size="small"/>
        </el-col>
        <el-col :span="4">
             <el-input v-model="planItem.price_to" placeholder="Цена до" size="small"/>
        </el-col>
        <el-col :span="4">
            <el-input v-model="planItem.duration_from" placeholder="Срок от" size="small"/>
        </el-col>
        <el-col :span="4">
            <el-input v-model="planItem.duration_to" placeholder="Срок до" size="small"/>
        </el-col>
        
    </el-row>
     </el-form>
    <el-divider border-style="dashed" />
   
   
     

<!--      <el-button class="button" @click="addPlanItem">Добавить</el-button> -->
      
      
    `
});
app.component('regionSelector', {
    setup() {
        const regions = inject('regions');


        return {regions};

    },
    props: ['planItem'],
    methods: {},
    template: `

      <el-select v-model="planItem.region_id" placeholder="Область" size="small" filterable  filterable no-match-text="Не найден">
    <el-option
      v-for="item in regions"
      :key="item.id"
      :label="item.title"
      :value="item.id"
    />
  </el-select>
 
    `
});
app.component('diagnosisSelector', {
    setup() {

        const diagnosis = inject('diagnosis');

        return {diagnosis};

    },
    props: ['planItem'],
    methods: {},
    template: `
      <el-select v-model="planItem.diagnosis_id" placeholder="Диагноз" size="small" filterable no-match-text="Не найден">
    <el-option
      v-for="item in diagnosis"
      :key="item.id"
      :label="item.code+' '+item.title"
      :value="item.id"
    />
  </el-select>
 
    `
});
app.component('operationSelector', {
    setup() {

        const operations = inject('operations');

        return {operations};

    },
    props: ['planItem'],
    methods: {
        changeOperation() {
            let operation=this.operations.find(o=>o.id===this.planItem.operation_id);
            console.log(operation)
            this.planItem.price_from = operation.price_from;
            this.planItem.price_to = operation.price_to;
            this.planItem.duration_from = operation.duration_from;
            this.planItem.duration_to = operation.duration_to;
        }


    },
    template: `
    <el-select v-model="planItem.operation_id" placeholder="Работа" size="small" filterable no-match-text="Не найдена" @change="changeOperation">
    <el-option
      v-for="item in operations"
      :key="item.id"
      :label="item.title"
      :value="item.id"
    />
  </el-select>
 
    `
});
// app.component('regionSelector2', {
//     setup() {
//         const tableData = ref([
//             {
//                 'tooth18': '18',
//                 'tooth17': '17',
//                 'tooth16': '16',
//                 'tooth15': '15',
//                 'tooth14': '14',
//                 'tooth13': '13',
//                 'tooth12': '12',
//                 'tooth11': '11',
//                 'tooth21': '21',
//                 'tooth22': '22',
//                 'tooth23': '23',
//                 'tooth24': '24',
//                 'tooth25': '25',
//                 'tooth26': '26',
//                 'tooth27': '27',
//                 'tooth28': '28',
//             },
//         ]);
//         const toothStatus = ref([
//             {
//                 'value': '1',
//                 'label': ' ',
//
//             },
//             {
//                 'value': '2',
//                 'label': 'C',
//             },
//             {
//                 'value': '3',
//                 'label': 'P',
//             }
//         ]);
//         const toothUpper = ref([
//             {'value': '18'}, {'value': '17'}, {'value': '16'}, {'value': '15'}, {'value': '14'}, {'value': '13'}, {'value': '12'}, {'value': '11'},
//             {'value': '21'}, {'value': '22'}, {'value': '23'}, {'value': '24'}, {'value': '25'}, {'value': '26'}, {'value': '27'}, {'value': '28'},
//
//         ]);
//         const toothLower = ref([
//             {'value': '48'}, {'value': '47'}, {'value': '46'}, {'value': '45'}, {'value': '44'}, {'value': '43'}, {'value': '42'}, {'value': '41'},
//             {'value': '31'}, {'value': '32'}, {'value': '33'}, {'value': '34'}, {'value': '35'}, {'value': '36'}, {'value': '37'}, {'value': '38'},
//
//         ]);
//         return {tableData, toothStatus, toothUpper, toothLower};
//     },
//     methods: {},
//     template: `
//     <el-row class="row-bg" justify="center">
//         <el-col :span="24">
//             <el-button>Полость рта</el-button>
//         </el-col>
//     </el-row>
//     <el-row class="row-bg" justify="center">
//         <el-col :span="24">
//             <el-button>Верхняя челюсть</el-button>
//         </el-col>
//     </el-row>
//     <el-row class="row-bg" justify="center">
//         <el-col :span="12">
//          <el-button>10 сегмент</el-button>
//         </el-col>
//         <el-col :span="12">
//          <el-button>20 сегмент</el-button>
//         </el-col>
//     </el-row>
//     <el-row class="row-bg" justify="center">
//         <el-col :span="24">
//             <el-button v-for="(tooth, index) in toothUpper"
//             :key="tooth.value">{{tooth.value}}</el-button>
//         </el-col>
//     </el-row>
//     <el-row class="row-bg" justify="center">
//         <el-col :span="12">
//          <el-button size="small">30 сегмент</el-button>
//         </el-col>
//         <el-col :span="12">
//          <el-button>40 сегмент</el-button>
//         </el-col>
//     </el-row>
//     <el-row class="row-bg"justify="center">
//         <el-col :span="24">
//         <el-button>Нижняя челюсть</el-button>
//         </el-col>
//     </el-row>
//     `
// })
app.mount('#treatmentPlan');