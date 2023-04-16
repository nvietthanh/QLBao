<template>
    <div class="datatable">
        <div class="scroll-wrapper"></div>
        <el-table :data="items" :border="true" style="width: 100%" @selection-change="handleSelectionChange" @row-click="rowClick"
            :empty-text="textIsEmpty" @sort-change="sortChange" :sortable="false">
            <el-table-column v-if="enableSelectBox" align="center" type="selection" fixed width="45" />
            <el-table-column v-for="(field, index) in fields" :key="index" :fixed="field.fixed" :prop="field.key"
                :label="field.label" :align="field.align || `left`" :width="field.width || 'auto'"
                :minWidth="field.minWidth || 'auto'" :type="field.type" :sortable="field.sortable">
                <template #default="scope">
                    <slot :name="field.key" v-bind="scope">
                        {{ scope.row[field.key] }}
                    </slot>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
    props: {
        fields: { type: Array, default: () => [] },
        textIsEmpty: { type: String, default: 'Không có dữ liệu nào' },
        items: { type: Array, default: () => [] },
        paginate: {
            type: Object, default: () => {
            }
        },
        enableIndex: { type: Boolean, default: false },
        enableSelectBox: { type: Boolean, default: false },
        disableTableInfo: { type: Boolean, default: false },
        headerCenter: { type: Boolean, default: false },
        footerCenter: { type: Boolean, default: false },
        paginateBackground: { type: Boolean, default: true },
        defaultSort: {
            type: Object, default: () => {
            }
        },
        tableHeight: { type: Number },
    },
    emits: ['row-selected', 'page-change', 'sort-change', 'row-click'],
    data() {
        return {
            multipleSelection: [],
            row: null
        };
    },
    mounted() {
        this.scrollHorizontal();
    },
    updated() {
        document.querySelector('.el-scrollbar__view').scrollLeft = 0;
    },
    methods: {
        handleSelectionChange(selectedItems) {
            this.$emit('row-selected', selectedItems)
        },
        rowClick(row) {
            this.$emit('row-click', row)
        },
        sortChange(column) {
            this.$emit('sort-change', column)
            document.querySelector('.el-scrollbar__view').scrollLeft = 0;
        },
        scrollHorizontal() {
            this.$nextTick(() => {
                let triggerScroll = null;

                const tableEl = document.querySelector('.el-scrollbar__view');
                const element = document.querySelector('.el-table__body');

                if (document.querySelector('.is-scrolling-none') == null) {
                    const table = document.querySelector('.el-table')

                    const tableWidth = table.offsetWidth ? table.offsetWidth + 'px' : table.style.width
                    document.querySelector('.scroll-wrapper').style.width = tableWidth

                    document.querySelector('.scroll-wrapper').addEventListener('scroll', (event) => {
                        // prevent infinite trigger scroll
                        if (triggerScroll !== 'table') {
                            triggerScroll = 'top'
                            this.scrollHeaderLeft(event.currentTarget.scrollLeft)
                        } else {
                            triggerScroll = null
                        }
                    })

                    tableEl.addEventListener('scroll', (event) => {
                        // prevent infinite trigger scroll
                        if (triggerScroll !== 'top') {
                            triggerScroll = 'table'
                            this.scrollHeaderLeft(event.currentTarget.scrollLeft)
                            // check add class scroll-left or right
                            const scrollbarWidth = element.offsetWidth - table.offsetWidth
                            if (event.currentTarget.scrollLeft < scrollbarWidth / 2) {
                                table.classList.remove('is-scrolling-right')
                                table.classList.add('is-scrolling-left')
                            } else {
                                table.classList.remove('is-scrolling-left')
                                table.classList.add('is-scrolling-right')
                            }
                        } else {
                            triggerScroll = null
                        }
                    })
                }

                let isDown = false;
                let startX;
                let scrollLeft = 0;
                let startY;
                let scrollTop = 0;
                element.addEventListener('mousedown', (e) => {
                    isDown = true;
                    element.classList.add('active')
                    startX = e.pageX - element.offsetLeft
                    startY = e.pageY - element.offsetTop
                    scrollLeft = tableEl.scrollLeft
                    scrollTop = tableEl.scrollTop
                })
                const moveListener = (e) => {
                    if (!isDown) {
                        return;
                    }
                    e.preventDefault()
                    const x = e.pageX - element.offsetLeft
                    const y = e.pageY - element.offsetTop
                    const walkX = (x - startX) * 3
                    const walkY = (y - startY) * 3
                    if (walkX !== 0) {
                        tableEl.scrollLeft = scrollLeft - walkX;
                    }
                    if (walkY !== 0) {
                        tableEl.scrollTop = scrollTop - walkY
                    }
                }
                element.addEventListener('mousemove', moveListener)
                const upListener = () => {
                    isDown = false;
                    element.classList.remove('active');
                }
                element.addEventListener('mouseup', upListener)
                element.addEventListener('mouseleave', upListener)
            })
        },
        scrollHeaderLeft(val) {
            document.querySelector('.el-table__header-wrapper').scrollLeft = val;
        },
    }
};
</script>

<style>
.datatable .el-scrollbar__view {
    overflow-x: scroll;
    display: block !important;
}

.datatable .el-table .el-table__body.active {
    cursor: grabbing;
}
</style>
