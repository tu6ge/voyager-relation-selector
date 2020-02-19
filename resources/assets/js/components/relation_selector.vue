<template>
    <el-cascader 
        :props="props_data" 
        :value="value"
        @change="handleChange"
    ></el-cascader>
</template>
<script>
import { Cascader } from 'element-ui';
// import 'element-ui/lib/theme-chalk/cascader.css'
// import 'element-ui/lib/theme-chalk/icon.css'
const axios = require('axios');

export default {
    name:'relation-selector',
    props:{
        level:{
            type: Number,
            default:3,
        },
        value:{
            type: Array,
            default:function(){
                return [];
            },
        }
    },
    data:function(){
        let that = this
        return { 
            //value:[220, 250, 254],
            props_data: {
                lazy: true,
                lazyLoad (node, resolve) {
                    const { level ,value } = node;
                    let val  = value ? value: 0
                    axios.get('/vrs/region/'+val)
                        .then(res=>{
                            if(res.status!= 200){
                                return false
                            }
                            const nodes = res.data.map(item=>({
                                value:item.id,
                                label:item.name,
                                leaf: item.level >= that.level
                            }))
                            resolve(nodes);
                        });
                }
            }
        };
    },
    components: {
        [Cascader.name]: Cascader,
    },
    methods:{
        handleChange(val){
            this.$emit('input', val);
        }
    }
}
</script>