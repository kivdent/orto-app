/* jshint esversion: 6 */

const { defineStore } = Pinia;
export const useDsStore=defineStore('dsStore',{
    state:()=>({
        diagnosis: [
            {
                id: 1,
                code: 'K05.1',
                title: 'Кариес',
            }, {
                id: 2,
                code: 'K05.1',
                title: 'Пульпит'
            },
        ]
    })
})