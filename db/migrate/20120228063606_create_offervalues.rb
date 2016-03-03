class CreateOffervalues < ActiveRecord::Migration
  def change
    create_table :offervalues do |t|
      t.integer :id
      t.string :time
      t.float :monday
      t.float :tuesday
      t.float :wednesday
      t.float :thursday
      t.float :friday
      t.float :saturday
      t.float :sunday

      t.timestamps
    end
  end
end
