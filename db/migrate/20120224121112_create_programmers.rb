class CreateProgrammers < ActiveRecord::Migration
  def change
    create_table :programmers do |t|
      t.string :name
      t.text :description

      t.timestamps
    end
  end
end
