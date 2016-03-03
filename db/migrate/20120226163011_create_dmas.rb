class CreateDmas < ActiveRecord::Migration
  def change
    create_table :dmas do |t|
      t.string :name
      t.integer :city_id

      t.timestamps
    end
  end
end
