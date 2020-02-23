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
        },
        resources_url:{
            type: String,
            required: true,
            validator: function (value) {
                return value.match('__pid__') != null
            }
        }
    },
    data:function(){
        return {
        };
    },
    components: {
        [Cascader.name]: Cascader,
    },
    methods:{
        handleChange(val){
            this.$emit('input', val);
        }
    },
    computed:{
        props_data(){
            let resources_url = this.resources_url
            return {
                lazy: true,
                lazyLoad (node, resolve) {
                    const { level ,value } = node;
                    let val  = value ? value: 0
                    
                    axios.get(resources_url.replace('__pid__', val))
                        .then(res=>{
                            if(res.status!= 200){
                                return false
                            }
                            resolve(res.data);
                        });
                }
            }
        }
    }
}
</script>