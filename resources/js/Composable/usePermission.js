import { computed } from 'vue';
export const  usePermission = (permission,permissions) => {
        const can = computed(() => {
            return permissions.includes(permission);
        });



    return { can };
}
