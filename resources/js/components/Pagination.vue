<template>
    <div>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a @click="changePage(pagination.current_page - 1)">Previous</a>
            </li>
            <li v-for="page in pages" :key="page" :class="{ active: page == pagination.current_page }">
                <a @click="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a @click="changePage(pagination.current_page + 1)">Next</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['pagination'],
        computed: {
            pages() {
                if (!this.pagination.to) {
                    return [];
                }
                
                const from = this.pagination.current_page - 2;
                const to = this.pagination.current_page + 2;
                let pages = [];

                for (let page = from; page <= to; page++) {
                    if (page >= 1 && page <= this.pagination.last_page) {
                        pages.push(page);
                    }
                }

                return pages;
            }
        },
        methods: {
            changePage(page) {
                this.$emit('page-changed', page);
            }
        }
    };
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}

.pagination ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.pagination li {
  display: inline-block;
  margin-right: 0.5rem;
}

.pagination li.active a {
  background-color: #007bff;
  color: #fff;
}

.pagination li a {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  border: 1px solid #dee2e6;
  color: #007bff;
  text-decoration: none;
}

.pagination li a:hover {
  background-color: #007bff;
  color: #fff;
}
</style>