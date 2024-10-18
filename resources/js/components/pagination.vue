<template>
    <div v-if="totalPages === 0 || !totalPages" class="text-center my-3">
        No Record Found
    </div>
    <div class="pagination my-4" v-else>
        <div class="info left">
            <div>Showing page {{ currentPage }} of {{ totalPages }} pages (Total {{ totalItems }} items)</div>
        </div>
        <div class="button right">
            <button @click="goToFirstPage" v-if="currentPage > 1" class="btn btn-light m-1">
                First
            </button>
            <button @click="prevPage" v-if="currentPage > 1" class="btn btn-light m-1">
                Previous
            </button>
            <button @click="nextPage" v-if="currentPage < totalPages" class="btn btn-light m-1">
                Next
            </button>
            <button @click="goToLastPage" v-if="currentPage < totalPages" class="btn btn-light m-1">
                Last
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: Number,
        totalPages: Number,
        totalItems: Number
    },
    methods: {
        prevPage() {
            if (this.currentPage > 1) {
                this.$emit('page-change', this.currentPage - 1);
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.$emit('page-change', this.currentPage + 1);
            }
        },
        goToFirstPage() {
            if (this.currentPage > 1) {
                this.$emit('page-change', 1);
            }
        },
        goToLastPage() {
            if (this.currentPage < this.totalPages) {
                this.$emit('page-change', this.totalPages);
            }
        }
    }
};
</script>

<style scoped>
.btn-light:hover {
    background-color: #70b7e3;
}

.btn-light {
    border: black 1px solid;
    font-size: 13px;
}

.pagination {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
}

</style>
