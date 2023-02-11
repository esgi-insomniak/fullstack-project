describe('template spec', () => {
  it('passes', () => {
    cy.visit(`${Cypress.env('HOST_URL')}login`)
    cy.login(Cypress.env('USER_ID'), Cypress.env('USER_PSWD'))
    cy.url().should('include', '/home')
    cy.contains('div', 'Services').click()
    cy.url().should('include', '/services')
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('select').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('input[name="kilometrage"]').type(Math.floor(Math.random() * (100000 - 5000) + 5000))
    cy.get('button').contains('Question suivante').click()
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('ul[class="formkit-options"]').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('ul[class="formkit-options"]').children().eq(random).click()
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select').children().then($childrens => {
      const random = Math.floor(Math.random() * $childrens.length)
      cy.get('select').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Question suivante').click()
    cy.get('select').children().then($childrens => {
      const random = Math.floor(Math.random() * ($childrens.length - 1)) + 1
      cy.get('select').select($childrens.eq(random).val())
    })
    cy.get('button').contains('Demande de RDV').click()
    cy.get('div').children().contains('Questionnaire terminer').should('be.visible')
  })
})