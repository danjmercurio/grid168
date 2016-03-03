class CreateOffersProgrammersJoinTable < ActiveRecord::Migration
  def change
    create_table :offers_programmers, :id => false do |t|
      t.references :programmer, :offer
    end

    add_index :offers_programmers, [:offer_id, :programmer_id], :unique => true
  end

end
