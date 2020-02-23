
new Vue({
    el:'#relation_selector_{{$id}}',
    data:function(){
        return {
            value:{{$value}},
        }
    },
    computed:{
        value_level_0:function(){
            return this.value[0] || 0;
        },
        value_level_1:function(){
            return this.value[1] || 0;
        },
        value_level_2:function(){
            return this.value[2] || 0;
        },
        value_level_3:function(){
            return this.value[3] || 0;
        },
        value_level_4:function(){
            return this.value[4] || 0;
        },
    },
    methods: {
    }
});
