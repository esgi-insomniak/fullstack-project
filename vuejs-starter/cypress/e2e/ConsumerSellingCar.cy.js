describe('template spec', () => {
  it('passes', () => {
    cy.visit(`${Cypress.env('HOST_URL')}login`)
    cy.login(Cypress.env('USER_ID'), Cypress.env('USER_PSWD'))
    cy.url().should('include', '/home')
    cy.get('*[class^="w-1/4 flex justify-end items-center space-x-3 relative"]').children().eq(1).click()
    cy.get('a[href="/me/list/orders/in-progress"]').click()
    cy.url().should('include', 'orders/in-progress')
    cy.get('summary').eq(1).click()
    cy.get('a[href="/me/list/sales').click()
  })
})