import { computed,isRef} from 'vue';
export const  useMonthlyPayment = (total,insertRate,years) => {
        const monthlyPayment = computed(() => {
            const principle = isRef(total) ? total.value : total;
            const monthlyInterest = isRef(insertRate) ? insertRate.value / 100 / 12 : insertRate / 100 / 12;
            const numberOfPaymentMonths = isRef(years) ? years.value * 12 : years * 12;
            return (
             (principle *
                    monthlyInterest *
                    Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) /
                (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
            );
        });

    const totalPaid =computed(()=>{
        return isRef(years) ? years.value * 12 * monthlyPayment.value : years * 12 * monthlyPayment.value;

    });

    const totalInsert = computed(()=>{
        return totalPaid.value - (isRef(total) ? total.value : total);
    });

    return { monthlyPayment, totalPaid, totalInsert };
}
