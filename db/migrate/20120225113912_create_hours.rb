class CreateHours < ActiveRecord::Migration
  def change
    create_table :hours do |t|
      t.integer :day
      t.float :hour
      t.integer :offer_id

      t.timestamps
    end
  end
end
