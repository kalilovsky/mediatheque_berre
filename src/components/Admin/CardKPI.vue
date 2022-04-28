<template>
    <div class="cardkpi">
        <div>
            <div class="numbers">{{ number }}</div>
            <div class="cardName">{{ cardName }}</div>
        </div>
        <div class="iconBx">
            <i :class="'pi ' + icon"></i>
        </div>
    </div>
</template>

<script>
export default {
    props: ['number', 'cardName', 'icon'],
}
</script>

<style>
.cardkpi {
    position: relative;
    background: var(--white);
    padding: 20px 10px;
    border-radius: 20px;
    display: flex;
    justify-content: space-between;
    cursor: pointer;
}

.cardkpi .numbers {
    position: relative;
    font-weight: 500;
    font-size: 2.5em;
    color: var(--blue);
}

.cardkpi .cardName {
    color: var(--black2);
    font-size: 1.1em;
    margin-top: 5px;
    font-weight: bold;
}

.cardkpi .iconBx i {
    font-size: 3.5em;
    color: var(--black2);
}

.cardkpi:hover {
    background: var(--blue);
}

.cardkpi:hover .numbers,
.cardkpi:hover .cardName,
.cardkpi:hover .iconBx i {
    color: var(--white);
}
</style>