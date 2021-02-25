<template>
    <div>
        <div class="container mt-5">
            <div id="records">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td data-name="id">ID</td>
                        <td data-name="symbol">Symbol</td>
                        <td data-name="open">High</td>
                        <td data-name="high">Low</td>
                        <td data-name="low">Price</td>
                        <td data-name="created_at">Created at</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="hRecords" v-for="hRecord in hRecords ">
                        <td> {{hRecord.id}}</td>
                        <td> {{hRecord.symbol}}</td>
                        <td> {{hRecord.open}}</td>
                        <td> {{hRecord.high}}</td>
                        <td> {{hRecord.low}}</td>
                        <td> {{hRecord.created_at}}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="10">No records found</td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "history",
    data: function(){
        return {
            hRecords: [],
            count: 0,
            offset: 0,
            limit: 10
        }
    },
    created: function() {

        let $this = this;
        axios.post('/api/stock/index', {
        })
        .then(function (response) {
            $this.hRecords =  response.data.data
        }).catch(function (error) {
            console.log(error);
        });

    }
}
</script>

<style scoped>

</style>
